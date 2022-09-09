<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\Color;
use App\Entity\Bijoux;
use App\Entity\Expedition;
use App\Entity\CartProduct;
use App\Form\CartProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirBijouxController extends AbstractController
{
    #[Route('/voir/bijoux-{id}', name: 'voir_bijoux', methods: ['GET', 'POST'])]
    public function voirBijoux(Bijoux $bijoux ,EntityManagerInterface $entityManager, Request $request): Response
    {
        $bijou = $entityManager->getRepository(Bijoux::class)->findBy(['id'=>$bijoux->getId()]);
        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$bijou[0]->getColor()]);
        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $cartProduct= new CartProduct();

        $form = $this->createForm(CartProductFormType::class)->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) 
        {              
            $cart = $entityManager->getRepository(Cart::class)->findOneBy(['user'=>$user, 'status'=>'active']);
            
            if ($cart == null) {
               $cart = new Cart();
               $cart->setCreatedAt(new DateTime());
               $cart->setStatus('active');
            }
     
            $cartProduct->setCreatedAt(new DateTime());
            $cartProduct->setUpdatedAt(new DateTime());
            $cartProduct->setBijoux($bijou[0]);
            $quantity = $form->get('quantity')->getData();
            $cartProduct->setQuantity($quantity);
            $cartProduct->setPrice($bijou[0]->getPrice()*$quantity);
            $entityManager->persist($cartProduct);
            
            $cart->setUpdatedAt(new DateTime());     
            $cart->setUser($user);
            $cart->addCartProduct($cartProduct);
          
            $entityManager->persist($cart);
            $entityManager->flush();

        }

        return $this->render('voir_bijoux/v_bijoux.html.twig', [
            'bijou' => $bijou,
            'color' => $color,
            'expedition' => $expedition,
            'form' => $form->createView()
            
        ]);
    }
}
