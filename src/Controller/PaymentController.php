<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\CartProduct;
use App\Entity\OrderProduct;
use App\Entity\UserPostalAdress;
use App\Entity\ProductsQuantities;
use Symfony\Component\Mime\Address;
use App\Exception\NotInCartException;
use Doctrine\ORM\EntityManagerInterface;
use App\Exception\NotEnoughInStockException;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Exception\PaymentNotCompletedException;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\PaymentAmountMissmatchException;
use Symfony\Component\HttpFoundation\JsonResponse;
use PayPalCheckoutSdk\Payments\AuthorizationsGetRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsCaptureRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    #[Route('/checkout/payment-{user}-{cart}', name: 'payment', methods:['GET', 'POST'])]
    public function payment(User $user, EntityManagerInterface $entityManager, Request $request): Response
    {
        $livraison = $request->get('postFee');

        $cart = $entityManager->getRepository(Cart::class)->findBy([
            'id' => $request->get('cart')
        ]);

        if ($cart[0]->getCartProduct() == null) {
            $this->redirectToRoute('default_home');
        }
        $userPostAdress = $entityManager->getRepository(UserPostalAdress::class)->findOneBy(['user' => $user->getId()]);

        $cartProducts = null;

        $numberOfItem = null;

        if ($cart !== null) {
            $numberOfItem = $cart[0]->getCartProduct()->count();
        }

        if ($cart !== null) {
            $cartProducts = $cart[0]->getCartProduct()->toArray();
        }

        $totalPrice = 0;

        // Boucle pour récuper le prix total de tout les produits du panier
        if ($numberOfItem !== null) {
            foreach ($cartProducts as $value) {
                $totalPrice = $totalPrice + ($value->getPrice() * $value->getQuantity());
            }
        }

        $totalPriceFinal = $totalPrice + $livraison;

        $cart[0]->setTotalPrice($totalPrice);

        $entityManager->persist($cart[0]);
        $entityManager->flush();

        // Partie paypal
        $totalPriceFinal2 = $totalPriceFinal / 100;

        $order = json_encode([
            'purchase_units' => [[
                'description' => 'Panier Metallian Eshop',
                'items' => array_map(function($product) {
                    return [
                        'name' => $product->getTitle(),
                        'quantity' => $product->getQuantity(),
                        'unit_amount' => [
                            'value' => $product->getPrice() / 100,
                            'currency_code' => 'EUR',
                        ],
                        'sku' => $product->getSku(),
                    ];                  
                }, $cartProducts),
                'amount' => [
                    'currency_code' => 'EUR',
                    'value' => $totalPriceFinal2,
                    'breakdown' => [
                        'item_total' => [
                            'currency_code' => 'EUR',
                            'value' => $totalPrice / 100,
                        ],
                        'shipping' => [
                            'currency_code' => 'EUR',
                            'value' => $livraison / 100,
                        ],
                    ]
                ],
                'shipping' => [
                    'address' => [
                        'country_code' => 'FR',
                        'address_line_1' => $userPostAdress->getAdress(),
                        'admin_area_2' => $userPostAdress->getCity(),
                        'postal_code' => $userPostAdress->getPostCode(),
                    ],
                    'name' => [
                        'full_name' => $user->getFirstname() . ' ' . $user->getLastname(),
                    ]
                ]
            ]]
        ]);

        $paypal = <<<HTML
      

            <script src="https://www.paypal.com/sdk/js?client-id=AdNolTxLQnuKJE036RC3Beg75EhBX7ZDv0mlIK4P5Rc98MjanzAIBJhAg2IyhD0z4lkqT9Ob5wyJC39-&currency=EUR&locale=fr_FR&intent=authorize"></script>

            <!-- Set up a container element for the button -->

            <div id="paypal-button-container" class="col-12 mt-4"></div>

            <script>

            paypal.Buttons({

                // Sets up the transaction when a payment button is clicked

                createOrder: (data, actions) => {

                return actions.order.create({$order});

                },

                // Finalize the transaction after payer approval

                onApprove: (data, actions) => {
                    actions.order.authorize().then(function(authorization) {
                        const authorizationId = authorization.purchase_units[0].payments.authorizations[0].id

                        let route = '{{ path('paypal', {'cart': cart.id, 'livraison': livraison}) }}';

                        return fetch(route, {
                            method: 'POST',
                            redirect: 'manual',
                            headers: {
                                'content-type': 'application/json'
                            },
                            body: JSON.stringify({authorizationId}),
                        })
                    }).then((response) => response.json())
                    .then((responseCompleted) => {
                        if (responseCompleted.status == "SUCCESS") {
                            
                            window.location.href = responseCompleted.orderId;
  
                        }else{
                             alert("it didn't work");
                        }
                    })
                }

            }).render('#paypal-button-container');

            </script>
        HTML;

        return $this->render('payment/payment.html.twig', [
            'userPostAdress' => $userPostAdress,
            'totalPriceFinal' => $totalPriceFinal,
            'livraison' => $livraison,
            'totalPrice' => $totalPrice,
            'cart' => $cart[0],
            'paypal' => $paypal
        ]);
    }

    #[Route('/checkout/paypal-{cart}-{livraison}', name: 'paypal', methods:['GET', 'POST'])]
    public function paypal(Request $request, Cart $cart, MailerInterface $mailer, EntityManagerInterface $entityManager): JsonResponse
    {
        $clientId = 'AdNolTxLQnuKJE036RC3Beg75EhBX7ZDv0mlIK4P5Rc98MjanzAIBJhAg2IyhD0z4lkqT9Ob5wyJC39-';
        $secret = 'EL-kbarXbZIu8ZlxqrTjLROtH44Yw8SrNd8Jz7zxsPUpLGrNITAhWZevnv0gtHBZB0LAh2ixst5ph115';

        $environment = new SandboxEnvironment($clientId, $secret);

        $client = new PayPalHttpClient($environment);

        $test = json_decode($request->getContent(), true);

        $requestPaypal = new AuthorizationsGetRequest($test['authorizationId']);
        
        $authorizationResponse = $client->execute($requestPaypal);

        $amount = (int)(floatval($authorizationResponse->result->amount->value) * 100);

        if ($amount !== $cart->getTotalPrice() + $request->get('livraison')) {
            throw new PaymentAmountMissmatchException();
        }

        // Vérifier si le stock est dispo
        $orderId = $authorizationResponse->result->supplementary_data->related_ids->order_id;
        $requestOrder = new OrdersGetRequest($orderId);
        $orderResponse = $client->execute($requestOrder);

        // foreach ($orderResponse->result->purchase_units[0]->items as $value) {

        //     if ($entityManager->getRepository(ProductsQuantities::class)->findOneBy(['sku' => $value->sku]) == null) {
        //         throw new NotInCartException();
        //     }

        //     if (($entityManager->getRepository(ProductsQuantities::class)->findOneBy(['sku' => $value->sku])->getStock() - $value->quantity) < 0) {
        //         throw new NotEnoughInStockException();
        //     }

        //     if ($entityManager->getRepository(ProductsQuantities::class)->findOneBy(['sku' => $value->sku])->getDiscount()  == null) {

        //         if ($entityManager->getRepository(ProductsQuantities::class)->findOneBy(['sku' => $value->sku])->getProducts()->getPrice() !== (($value->unit_amount->value) * 100)) {
        //             throw new NotEnoughInStockException();
        //         }

        //     } else {

        //         if ($entityManager->getRepository(ProductsQuantities::class)->findOneBy(['sku' => $value->sku])->getDiscount() !== ($value->unit_amount->value) * 100) {
        //             throw new NotEnoughInStockException();
        //         }
        //     }
        // }

        // Capturer le paiement
        $requestCapture = new AuthorizationsCaptureRequest($test['authorizationId']);
        $responseCapture = $client->execute($requestCapture);
        if ($responseCapture->result->status !== 'COMPLETED') {
            throw new PaymentNotCompletedException();
        }

        // Sauvegarder les informations de l'utilisateur et new Order
        $user = $this->getUser();

        $order = new Order;
        $order->setStatus('paid');
        $order->setPaymentMethod('Paypal');
        $order->setPaypalAuthorizationId($test['authorizationId']);
        $order->setPaypalOrderId($orderId);

        $userPostAdress = $entityManager->getRepository(UserPostalAdress::class)->findOneBy(['user' => $this->getUser()]);

        $cartProducts = null;

        $numberOfItem = null;

        if ($cart !== null) {
            $numberOfItem = $cart->getCartProduct()->count();
        }

        if ($cart !== null) {
            $cartProducts = $cart->getCartProduct()->toArray();
        }

        $totalPrice = 0;

        // Boucle pour récuper le prix total de tout les produits du panier
        if ($numberOfItem !== null) {
            foreach ($cartProducts as $value) {
                $totalPrice = $totalPrice + ($value->getPrice() * $value->getQuantity());
            }
        }

        $totalPriceFinal = $cart->getTotalPrice();

        $order->setCreatedAt(new DateTime());
        $order->setUpdatedAt(new DateTime());
        $order->setUser($user);
        $order->setsubTotal($totalPrice);
        $order->setTotal($totalPriceFinal);
        $order->setShipping(500);
        $order->setFirstName($user->getFirstname());
        $order->setLastName($user->getLastname());
        $order->setMobile($user->getPhoneNumber());
        $order->setEmail($user->getEmail());
        $order->setAdress($userPostAdress->getAdress());
        $order->setAdditionalAdress($userPostAdress->getAdditionalAdress());
        $order->setPostCode($userPostAdress->getPostCode());
        $order->setCity($userPostAdress->getCity());
        $order->setCountry('France');

        foreach ($cart->getCartProduct() as $cartProduct) {
            $orderProduct = new OrderProduct;
            $orderProduct->setCreatedAt(new DateTime());
            $orderProduct->setUpdatedAt(new DateTime());
            $orderProduct->setProducts($cartProduct->getProducts());
            $orderProduct->setPhoto($cartProduct->getPhoto());
            $orderProduct->setSubCategory($cartProduct->getSubCategory());
            $orderProduct->setPrice($cartProduct->getPrice());
            $orderProduct->setColor($cartProduct->getColor());  
            $orderProduct->setSize($cartProduct->getSize());
            $orderProduct->setQuantity($cartProduct->getQuantity());
            $orderProduct->setTitle($cartProduct->getTitle());
            $orderProduct->setSku($cartProduct->getSku());
            $orderProduct->setOrderId($order);

            if ($orderProduct->getProducts() != null) {
                $product = $entityManager->getRepository(ProductsQuantities::class)->findOneBy(['products' => $orderProduct->getProducts()]);

                if ($product->getStock() >= 1) {
                    
                    if ($product->getStock() - $orderProduct->getQuantity() >= 0) {

                        $product->setStock($product->getStock() - $orderProduct->getQuantity());
                        $entityManager->persist($product);
                        $entityManager->flush();

                    } else {
                        return $this->redirectToRoute('show_cart_details');
                    }
                    
                } else {
                    return $this->redirectToRoute('show_cart_details');
                }
                
            }
            
            $entityManager->persist($orderProduct);

        }

        $cart->setStatus('archived');
        $entityManager->persist($cart);
        $entityManager->persist($order);
        $entityManager->flush();

        $confirmationMail = (new TemplatedEmail())
            ->from(new Address('test@ornchanarong.com', 'Metallian Store'))
            ->to($user->getEmail())
            ->subject('Confirmation de votre commande Metallian Eshop')
            ->htmlTemplate('email/order_confirmation_mail.html.twig')
            ->context([
                'user' => $user,
                'cartProducts' => $cartProducts,
                'totalPriceFinal' => $totalPriceFinal + 500
        ]);

        $newOrderEmail = (new TemplatedEmail())
            ->from(new Address('test@ornchanarong.com', 'Metallian Store'))
            ->to('vahnra@gmail.com')
            ->subject('Nouvelle commande Metallian Eshop numéro : ' . $order->getId())
            ->htmlTemplate('email/new_order_mail.html.twig')
            ->context([
                'user' => $user,
                'order' => $order->getId(),
                'cartProducts' => $cartProducts,
                'totalPriceFinal' => $totalPriceFinal + 500
        ]);

        $mailer->send($confirmationMail);
        $mailer->send($newOrderEmail);

        

        return new JsonResponse(["status" => "SUCCESS", "orderId" => "confirmation-order-" . $order->getId() . ""]);
    }
}
