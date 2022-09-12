<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Material;
use App\Entity\Vetement;
use App\Entity\Expedition;
use App\Entity\CartProduct;
use App\Form\CartProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirVetementController extends AbstractController
{
    #[Route('/voir/vetement-{id}', name: 'voir_vetement', methods:['GET', 'POST'])]
    public function voirVetement(Vetement $vetements, EntityManagerInterface $entityManager, Request $request): Response
    {
        $vetement = $entityManager->getRepository(Vetement::class)->findBy(['id'=>$vetements->getId()]);

        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$vetement[0]->getColor()]);

        $size = $entityManager->getRepository(Size::class)->findBy(['id'=>$vetement[0]->getSize()]);
        
        $material = $entityManager->getRepository(Material::class)->findBy(['id'=>$vetement[0]->getMaterial()]);
    

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
            $cartProduct->setVetement($vetement[0]);
            $quantity = $form->get('quantity')->getData();
            $cartProduct->setQuantity($quantity);
            $cartProduct->setPrice($vetement[0]->getPrice());
            $cartProduct->setTitle($vetement[0]->getTitle());
            $cartProduct->setPhoto($vetement[0]->getPhoto());
            $cartProduct->setSubCategory($vetement[0]->getSousCategorie());         
            
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

            $entityManager->persist($cart);
            $entityManager->flush();

        }



        return $this->render('voir_vetement/voir_vetement.html.twig', [
            'vetement' => $vetement,
            'color' => $color,
            'size' => $size,
            'material' => $material,
            'expedition' => $expedition,
            'form' => $form->createView()
        ]);
    }
}
