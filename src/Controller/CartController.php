<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Form\CartDetailsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'show_cart')]
    public function showCart(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $cart = $entityManager->getRepository(Cart::class)->findOneBy(['user'=>$user, 'status'=>'active']);

        $cartProducts = null;

        if ($cart != null) {
            $cartProducts = $cart->getCartProduct()->toArray();
        }
      
        return $this->render('cart/show_cart.html.twig', [
           'cartProducts' => $cartProducts
        ]);
    }

    #[Route('/cart-details', name: 'show_cart_details', methods:['GET', 'POST'])]
    public function showCartDetails(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();

        $cart = $entityManager->getRepository(Cart::class)->findOneBy(['user'=>$user, 'status'=>'active']);

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

        // On initialise des tableaux vide pour stocker les forms, et les produits du panier
        $forms = [];

        $formGroup = [];

        $formData = [];

        // Boucle pour creer les forms de chaque produit du panier
        if ($cartProducts != null) {
            
        foreach ($cartProducts as $index) {
            // On stock tout les produits dans le tableau formData
            $formData[$index->getID()] = $index;
            // On crée les form et les stock dans la variable $forms
            $forms[$index->getID()] = $this->container
            ->get('form.factory')
            ->createNamed('form' . $index->getID(), CartDetailsFormType::class, $index)->handleRequest($request);
            
        }
        
        // Boucle de fonction pour le submit de chaque form
        foreach ($forms as $form)    
        { 
            // If pour le submit
            if ($form->isSubmitted() && $form->isValid())
            {
                // On se sert de l'id du produit en question pour avoir le bon objet produit et on set la quantité demander
                $formData[$form->getData()->getId()]->setQuantity($form->get('quantity')->getData());
                // $formData[$form->getData()->getId()]->setPrice($form->get('quantity')->getData() * $form->getData()->getPrice());
                // On persist et on flush et on redirect
                $entityManager->persist($formData[$form->getData()->getId()]);
                $entityManager->flush();

                return $this->redirectToRoute('show_cart_details');
            }
        }

        // Boucle pour créer la vue de chaque form et on les stock dans la variable formGroup
        foreach ($forms as $form)
        {               
            array_push($formGroup, $form->createView());                                                          
        }  

        }


        return $this->render('cart/show_cart_details.html.twig', [
            'numberOfItem' => $numberOfItem,
            'totalPrice' => $totalPrice,
            'cartProducts' => $cartProducts,
            'formQuantity' => $formGroup
        ]);
    }

    #[Route('/delete-product-from-cart-{id}', name:'delete_product', methods:['GET', 'POST'])]
    public function hardDeleteProduct(CartProduct $cartProduct, EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityManager->remove($cartProduct);
        $entityManager->flush();
    
        return $this->redirectToRoute('show_cart_details');
    }
}
