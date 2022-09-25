<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Chaussures;
use App\Entity\Expedition;
use App\Entity\CartProduct;
use App\Form\CartProductFormType;
use App\Entity\ChaussuresQuantity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirChaussuresController extends AbstractController
{
    #[Route('/voir/chaussures-{id}', name: 'voir_chaussures', methods: ['GET', 'POST'])]
    public function index(Chaussures $chaussures, EntityManagerInterface $entityManager, Request $request): Response
    {
        $color = $request->get('color');

        $size = $request->get('size');

        $chaussure = $entityManager->getRepository(Chaussures::class)->findBy(['id'=>$chaussures->getId()]);

        $chaussuresVariations = $entityManager->getRepository(ChaussuresQuantity::class)->findBy(['chaussures' => $chaussures->getId()]);

        $couleurs = [];

        $sizes = [];

        foreach ($chaussuresVariations as $acc) {
            if (!in_array($acc->getColor(), $couleurs, true)) {
                array_push($couleurs, $acc->getColor());
            }
        }

        foreach ($chaussuresVariations as $acc) {
            if (!in_array($acc->getSize(), $sizes, true)) {
                array_push($sizes, $acc->getSize());
            }
        }
      
        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $cartProduct= new CartProduct();

        $form = $this->createForm(CartProductFormType::class)->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) 
        {              
            $cart = $entityManager->getRepository(Cart::class)->findOneBy(['token'=>$request->getSession()->get('id'), 'status'=>'active']);

            if ($user !== null && $cart == null) {
                $cart = $entityManager->getRepository(Cart::class)->findOneBy(['user'=>$user, 'status'=>'active'], ['updatedAt'=>'DESC']);
            }
            
            if ($cart == null) {
               $cart = new Cart();
               $cart->setCreatedAt(new DateTime());
               $cart->setStatus('active');
               $request->getSession()->set('id', uniqid(rand(), true));
            }
     
            $cartProduct->setCreatedAt(new DateTime());
            $cartProduct->setUpdatedAt(new DateTime());
            $cartProduct->setChaussures($chaussure[0]);
            $quantity = $form->get('quantity')->getData();
            $cartProduct->setQuantity($quantity);
            $cartProduct->setPrice($chaussure[0]->getPrice());
            $cartProduct->setTitle($chaussure[0]->getTitle());
            $cartProduct->setPhoto($chaussure[0]->getPhoto());
            $cartProduct->setColor($entityManager->getRepository(Color::class)->findOneBy(['id'=>$color]));
            $cartProduct->setSize($entityManager->getRepository(Size::class)->findOneBy(['id'=>$size]));
            $cartProduct->setSubCategory($chaussure[0]->getSousCategorie());

            $sku = $entityManager->getRepository(ChaussuresQuantity::class)->findOneBy([
                'chaussures' => $chaussure[0]->getId(), 
                'color' => $color,
                'size' => $size
            ])->getSku();

            $cartProduct->setSku($sku); 

            $entityManager->persist($cartProduct);
            
            $cart->setUpdatedAt(new DateTime());     
            $cart->setUser($user);
            $cart->addCartProduct($cartProduct);

            $token = $cart->getToken();
   
            if ($token == null) {
                $cart->setToken($request->getSession()->get('id'));
            } else {
                $cart->setToken($cart->getToken());
            }
            
        //   dd($cart);
            $entityManager->persist($cart);
            $entityManager->flush();

        }
        $similarItm = $entityManager->getRepository(Chaussures::class)->findBy([
            'sousCategorie' => $chaussure[0]->getSousCategorie(),
            'categorie' => $chaussure[0]->getCategorie(),
        ]);
    
        return $this->render('voir_chaussures/voir_chaussures.html.twig', [
            'chaussure' => $chaussure,
            'chaussuresVariations' => $chaussuresVariations,
            'chaussuresVariationsJs' => json_encode($chaussuresVariations),
            'couleurs' => $couleurs,
            'sizes' => $sizes,
            'expedition' => $expedition,
            'form' => $form->createView(),
            'similarItm' => $similarItm
            
        ]);
    }
}
