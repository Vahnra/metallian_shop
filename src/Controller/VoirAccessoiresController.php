<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Material;
use App\Entity\Expedition;
use App\Entity\Accessoires;
use App\Entity\CartProduct;
use App\Form\CartProductFormType;
use App\Repository\VetementRepository;
use App\Repository\ExpeditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirAccessoiresController extends AbstractController
{
    #[Route('/voir/accessoires-{id}', name: 'voir_accessoires', methods: ['GET', 'POST'])]
    public function voirAccessoires(Accessoires $accessoires, EntityManagerInterface $entityManager, Request $request): Response
    {
        $accessoire = $entityManager->getRepository(Accessoires::class)->findBy(['id'=>$accessoires->getId()]);
        
        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$accessoire[0]->getColor()]);

        $size = $entityManager->getRepository(Size::class)->findBy(['id'=>$accessoire[0]->getSize()]);
      
        $material = $entityManager->getRepository(Material::class)->findBy(['id'=>$accessoire[0]->getMaterial()]);

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
            $cartProduct->setAccessoires($accessoire[0]);
            $quantity = $form->get('quantity')->getData();
            $cartProduct->setQuantity($quantity);
            $cartProduct->setPrice($accessoire[0]->getPrice());
            $cartProduct->setTitle($accessoire[0]->getTitle());
            $cartProduct->setPhoto($accessoire[0]->getPhoto());
            $cartProduct->setSubCategory($accessoire[0]->getSousCategorie());

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

        return $this->render('voir_accessoires/voir_accessoires.html.twig', [
            'accessoire' => $accessoire,
            'color' => $color,
            'size' => $size,
            'material' => $material,
            'expedition' => $expedition,
            'form' => $form->createView()
            
        ]);
    }
}
