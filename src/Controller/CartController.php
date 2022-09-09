<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartProduct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'show_cart')]
    public function showCart(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $cart = $entityManager->getRepository(Cart::class)->findOneBy(['user'=>$user, 'status'=>'active']);

        // $count = $cart->getCartProduct()->count();

        $cartProducts = $cart->getCartProduct()->toArray();

      
        // dd($cartProducts);

      
        return $this->render('cart/show_cart.html.twig', [
           'cartProducts' => $cartProducts
        ]);
    }

    #[Route('/cart-details', name: 'show_cart_details', methods:['GET', 'POST'])]
    public function showCartDetails(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $cart = $entityManager->getRepository(Cart::class)->findOneBy(['user'=>$user, 'status'=>'active']);
        
        return $this->render('cart/show_cart_details.html.twig', [
         
         ]);
    }

}
