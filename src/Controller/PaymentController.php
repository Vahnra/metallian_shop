<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\UserPostalAdress;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
                        let route = '{{ path('default_home') }}';

                        // return window.location.replace(route);
                        return fetch(route, {
                            method: 'POST',
                            redirect: 'manual',
                            headers: {
                                'content-type': 'application/json'
                            },
                            body: JSON.stringify({authorizationId}),
                        })
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

    public function paypalUi()
    {
        return <<<HTML
      

                <script src="https://www.paypal.com/sdk/js?client-id=AdNolTxLQnuKJE036RC3Beg75EhBX7ZDv0mlIK4P5Rc98MjanzAIBJhAg2IyhD0z4lkqT9Ob5wyJC39-&currency=EUR&locale=fr_FR"></script>

                <!-- Set up a container element for the button -->

                <div id="paypal-button-container" class="col-12 mt-4"></div>

                <script>

                paypal.Buttons({

                    // Sets up the transaction when a payment button is clicked

                    createOrder: (data, actions) => {

                    return actions.order.create({

                        purchase_units: [{

                        amount: {

                            value: '77.44' // Can also reference a variable or function

                        }

                        }]

                    });

                    },

                    // Finalize the transaction after payer approval

                    onApprove: (data, actions) => {

                    return actions.order.capture().then(function(orderData) {

                        // Successful capture! For dev/demo purposes:

                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                        const transaction = orderData.purchase_units[0].payments.captures[0];

                        alert(`Transaction \${transaction.status}: \${transaction.id}\n\nSee console for all available details`);

                        // When ready to go live, remove the alert and show a success message within this page. For example:

                        // const element = document.getElementById('paypal-button-container');

                        // element.innerHTML = '<h3>Thank you for your payment!</h3>';

                        // Or go to another URL:  actions.redirect('thank_you.html');

                    });

                    }

                }).render('#paypal-button-container');

            </script>
HTML;
    }
}
