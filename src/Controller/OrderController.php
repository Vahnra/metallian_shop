<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Vetement;
use App\Entity\OrderProduct;
use App\Entity\UserPostalAdress;
use App\Entity\VetementQuantity;
use App\Entity\ChaussuresQuantity;
use App\Entity\ProductsQuantities;
use App\Entity\AccessoiresQuantity;
use App\Entity\OrderReclamation;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use App\Form\OrderTrackingInformationFormType;
use App\Form\SavFormType;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/profile/order-{id}', name: 'order_detail')]
    public function orderDetail(Order $order): Response
    {
        if ($order->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('default_home');
        }

        return $this->render('user/show_profile_order_detail.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/profile/invoice-{id}', name: 'order_invoice')]
    public function orderInvoice(Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($order->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('default_home');
        }

        $dompdf = new Dompdf(array('enable_remote' => true));
        $html = '<style>
                    .invoice-box {
                        max-width: 800px;
                        margin: auto;
                        padding: 30px;
                        border: 1px solid #eee;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
                        font-size: 16px;
                        line-height: 24px;
                        font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
                        color: #555;
                    }

                    .invoice-box table {
                        width: 100%;
                        line-height: inherit;
                        text-align: left;
                    }

                    .invoice-box table td {
                        padding: 5px;
                        vertical-align: top;
                    }

                    .invoice-box table tr td:nth-child(2) {
                        text-align: right;
                    }

                    .invoice-box table tr.top table td {
                        padding-bottom: 20px;
                    }

                    .invoice-box table tr.top table td.title {
                        font-size: 45px;
                        line-height: 45px;
                        color: #333;
                    }

                    .invoice-box table tr.information table td {
                        padding-bottom: 40px;
                    }

                    .invoice-box table tr.heading td {
                        background: #eee;
                        border-bottom: 1px solid #ddd;
                        font-weight: bold;
                    }

                    .invoice-box table tr.details td {
                        padding-bottom: 20px;
                    }

                    .invoice-box table tr.item td {
                        border-bottom: 1px solid #eee;
                    }

                    .invoice-box table tr.item.last td {
                        border-bottom: none;
                    }

                    .invoice-box table tr.total td:nth-child(2) {
                        border-top: 2px solid #eee;
                        font-weight: bold;
                    }

                    @media only screen and (max-width: 600px) {
                        .invoice-box table tr.top table td {
                            width: 100%;
                            display: block;
                            text-align: center;
                        }

                        .invoice-box table tr.information table td {
                            width: 100%;
                            display: block;
                            text-align: center;
                        }
                    }

                    /** RTL **/
                    .invoice-box.rtl {
                        direction: rtl;
                        font-family: Tahoma, \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
                    }

                    .invoice-box.rtl table {
                        text-align: right;
                    }

                    .invoice-box.rtl table tr td:nth-child(2) {
                        text-align: left;
                    }
                </style>
            </head>

            <body>
                <div class="invoice-box">
                    <table cellpadding="0" cellspacing="0">
                        <tr class="top">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td class="title">
                                            <img src="http://127.0.0.1:8000/images/LOGO_METALLIAN_ESHOP.png" style="width: 100%; max-width: 300px" />
                                        </td>

                                        <td>
                                            Commande #: '. $order->getId() .'<br />
                                            Date: ' . $order->getCreatedAt()->format('d-m-Y') . '<br />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr class="information">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td>
                                            Metallian Eshop<br />
                                            12345 Sunny Road<br />
                                            Sunnyville, CA 12345
                                        </td>

                                        <td>
                                            ' . $order->getLastName() . ' ' . $order->getFirstName() .'<br />
                                            ' . $order->getAdress() . '<br />
                                            ' . $order->getPostCode() . ', ' . $order->getCity() . '<br />
                                            ' . $order->getEmail() . '
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr class="heading">
                            <td>Méthode de paiement</td>

                            <td>Facture #</td>
                        </tr>

                        <tr class="details">
                            <td>' . $order->getPaymentMethod() . '</td>

                            <td>1000</td>
                        </tr>

                        <tr class="heading">
                            <td>Article</td>

                            <td>Prix</td>
                        </tr>'; 

                        foreach ($order->getOrderProducts() as $value) {

                            $html .= '
                            <tr class="item">
                                <td>' . $value->getTitle() . ', couleur: ' . $value->getColor() . ', taille: ' . $value->getSize() . ', quantité : ' . $value->getQuantity() . '</td>         

                                <td>' . $value->getPrice()/100 . ' €' . '</td>
                            </tr>';
                            
                        } 
                        
                        $html .= '
                        <tr class="item">
                            <td></td>

                            <td>' . 'Livraison: ' . $order->getShipping()/100 . ' €' . '</td>
                        </tr>
                        <tr class="total">
                            <td></td>

                            <td>' . 'Total: ' . $order->getTotal()/100 . ' €' . '</td>
                        </tr>
                    </table>
                </div>
            </body>';

        $dompdf->loadHtml($html);
        $dompdf->render();

        $invoiceName = 'Facture-' . $this->getUser()->getLastName() . '-commande' . $order->getId() . '.pdf';

        // file_put_contents("factures/" . $invoiceName , $dompdf);

        $order->setInvoice($invoiceName);
        $entityManager->persist($order);
        $entityManager->flush();

        $dompdf->stream($invoiceName);

        return $this->render('user/show_profile_order_invoice.html.twig', [
            'facture' => $dompdf
        ]);
    }

    #[Route('/profile/retour-order-{id}', name: 'order_retour-detail')]
    public function orderRetourDetail(Order $order, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SavFormType::class)->handleRequest($request);

        if ($order->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('default_home');
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $reclamation = new OrderReclamation;      

            $reclamation->setOrderNumber($order);
            $reclamation->setUser($this->getUser());
            $reclamation->setCreatedAt(new DateTime());

            if ($request->get('reason') == 1) {
                $reclamation->setType('Rétractation');
            }

            if ($request->get('reason') == 2) {
                $reclamation->setType('Demande de SAV');
            }
            
            $reclamation->setMessage($form->get('message')->getData());

            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('show_profile_orders_retour', [
                'id'=> $this->getUser()
            ]);
            
        }
        
        return $this->render('user/show_profile_order_retour_detail.html.twig', [
            'order' => $order,
            'form' => $form->createView()
        ]);
    }

    #[Route('/checkout/order-confirmation-{cart}', name: 'order_confirmation', methods:['GET'])]
    public function orderConfirmation(
        Cart $cart,
        MailerInterface $mailer,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $user = $this->getUser();

        $order = new Order;
        $order->setStatus('paid');

        $cart = $entityManager->getRepository(Cart::class)->findOneBy([
            'id' => $request->get('cart')
        ]);

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

        return $this->redirectToRoute('order_confirmation_message', [
            'order' => $order->getId(),
        ]);
    }

    #[Route('/checkout/confirmation-order-{order}', name:'order_confirmation_message', methods:['GET'])]
    public function orderConfirmationMessage(Order $order, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $order->getUser();

        if ($order->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('default_home');
        }

        $cartProducts = $order->getOrderProducts();

        $dompdf = new Dompdf(array('enable_remote' => true));
        $html = '<style>
                    .invoice-box {
                        max-width: 800px;
                        margin: auto;
                        padding: 30px;
                        border: 1px solid #eee;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
                        font-size: 16px;
                        line-height: 24px;
                        font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
                        color: #555;
                    }

                    .invoice-box table {
                        width: 100%;
                        line-height: inherit;
                        text-align: left;
                    }

                    .invoice-box table td {
                        padding: 5px;
                        vertical-align: top;
                    }

                    .invoice-box table tr td:nth-child(2) {
                        text-align: right;
                    }

                    .invoice-box table tr.top table td {
                        padding-bottom: 20px;
                    }

                    .invoice-box table tr.top table td.title {
                        font-size: 45px;
                        line-height: 45px;
                        color: #333;
                    }

                    .invoice-box table tr.information table td {
                        padding-bottom: 40px;
                    }

                    .invoice-box table tr.heading td {
                        background: #eee;
                        border-bottom: 1px solid #ddd;
                        font-weight: bold;
                    }

                    .invoice-box table tr.details td {
                        padding-bottom: 20px;
                    }

                    .invoice-box table tr.item td {
                        border-bottom: 1px solid #eee;
                    }

                    .invoice-box table tr.item.last td {
                        border-bottom: none;
                    }

                    .invoice-box table tr.total td:nth-child(2) {
                        border-top: 2px solid #eee;
                        font-weight: bold;
                    }

                    @media only screen and (max-width: 600px) {
                        .invoice-box table tr.top table td {
                            width: 100%;
                            display: block;
                            text-align: center;
                        }

                        .invoice-box table tr.information table td {
                            width: 100%;
                            display: block;
                            text-align: center;
                        }
                    }

                    /** RTL **/
                    .invoice-box.rtl {
                        direction: rtl;
                        font-family: Tahoma, \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
                    }

                    .invoice-box.rtl table {
                        text-align: right;
                    }

                    .invoice-box.rtl table tr td:nth-child(2) {
                        text-align: left;
                    }
                </style>
            </head>

            <body>
                <div class="invoice-box">
                    <table cellpadding="0" cellspacing="0">
                        <tr class="top">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td class="title">
                                            <img src="http://127.0.0.1:8000/images/LOGO_METALLIAN_ESHOP.png" style="width: 100%; max-width: 300px" />
                                        </td>

                                        <td>
                                            Commande #: '. $order->getId() .'<br />
                                            Date: ' . $order->getCreatedAt()->format('d-m-Y') . '<br />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr class="information">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td>
                                            Metallian Eshop<br />
                                            12345 Sunny Road<br />
                                            Sunnyville, CA 12345
                                        </td>

                                        <td>
                                            ' . $order->getLastName() . ' ' . $order->getFirstName() .'<br />
                                            ' . $order->getAdress() . '<br />
                                            ' . $order->getPostCode() . ', ' . $order->getCity() . '<br />
                                            ' . $order->getEmail() . '
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr class="heading">
                            <td>Méthode de paiement</td>

                            <td>Facture #</td>
                        </tr>

                        <tr class="details">
                            <td>' . $order->getPaymentMethod() . '</td>

                            <td>1000</td>
                        </tr>

                        <tr class="heading">
                            <td>Article</td>

                            <td>Prix</td>
                        </tr>'; 

                        foreach ($order->getOrderProducts() as $value) {

                            $html .= '
                            <tr class="item">
                                <td>' . $value->getTitle() . ', couleur: ' . $value->getColor() . ', taille: ' . $value->getSize() . ', quantité : ' . $value->getQuantity() . '</td>         

                                <td>' . $value->getPrice()/100 . ' €' . '</td>
                            </tr>';
                            
                        } 
                        
                        $html .= '
                        <tr class="item">
                            <td></td>

                            <td>' . 'Livraison: ' . $order->getShipping()/100 . ' €' . '</td>
                        </tr>
                        <tr class="total">
                            <td></td>

                            <td>' . 'Total: ' . $order->getTotal()/100 . ' €' . '</td>
                        </tr>
                    </table>
                </div>
            </body>';

        $dompdf->loadHtml($html);
        $dompdf->render();

        $invoiceName = 'Facture-' . $this->getUser()->getLastName() . '-commande' . $order->getId() . '.pdf';

        file_put_contents("factures/" . $invoiceName, $dompdf);

        $order->setInvoice($invoiceName);
        $entityManager->persist($order);
        $entityManager->flush();

        return $this->render('order/order_confirmation.html.twig', [
            'user' => $user,
            'order' => $order,
            'cartProducts' => $cartProducts
        ]);
    }

    #[Route('/admin/order-information-{id}', name:'order_sent', methods:['GET', 'POST'])]
    public function orderSent(Order $order, MailerInterface $mailer, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(OrderTrackingInformationFormType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setTrackingNumber($form->get('trackingNumber')->getData());
            $order->setTrackingLink($form->get('trackingLink')->getData());
            $order->setSentAt(new DateTime());
            $order->setStatus('sent');
            $entityManager->persist($order);
            $entityManager->flush();

            $orderDispatchEmail = (new TemplatedEmail())
                ->from(new Address('test@ornchanarong.com', 'Metallian Store'))
                ->to($order->getEmail())
                ->subject('Votre commande Metallian Eshop a été expédié, numéro : ' . $order->getId())
                ->htmlTemplate('email/order_dispatch_mail.html.twig')
                ->context([
                    'user' => $order->getUser(),
                    'order' => $order,
            ]);

            $mailer->send($orderDispatchEmail);

            return $this->redirectToRoute('admin');
        }

        return $this->render('order/order_sent.html.twig', [
            'order' => $order,
            'form' => $form->createView()
        ]);
    }
}
