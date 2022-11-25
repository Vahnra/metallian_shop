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
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use App\Form\OrderTrackingInformationFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/profile/order-{id}', name: 'order_detail')]
    public function orderDetail(Order $order): Response
    {
        if ($order->getUser() !== $this->getUser()) {
            $this->redirectToRoute('default_home');
        }
        
        return $this->render('user/show_profile_order_detail.html.twig', [
            'order' => $order
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
    public function orderConfirmationMessage(Order $order, Request $request): Response
    {
        $user = $order->getUser();

        if ($order->getUser() !== $this->getUser()) {
            $this->redirectToRoute('default_home');
        }

        $cartProducts = $order->getOrderProducts();

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
