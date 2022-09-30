<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\Color;
use App\Entity\Bijoux;
use App\Entity\Expedition;
use App\Entity\CartProduct;
use App\Entity\BijouxQuantity;
use App\Entity\FavoriteProduct;
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
        $color = $request->get('color');

        $size = $request->get('size');

        $bijou = $entityManager->getRepository(Bijoux::class)->findBy(['id'=>$bijoux->getId()]);

        $bijouxVariations = $entityManager->getRepository(BijouxQuantity::class)->findBy(['bijoux' => $bijoux->getId()]);

        $couleurs = [];

        $sizes = [];

        foreach ($bijouxVariations as $acc) {
            if (!in_array($acc->getColor(), $couleurs, true)) {
                array_push($couleurs, $acc->getColor());
            }
        }

        // foreach ($bijouxVariations as $acc) {
        //     if (!in_array($acc->getSize(), $sizes, true)) {
        //         array_push($sizes, $acc->getSize());
        //     }
        // }

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $form = $this->createForm(CartProductFormType::class)->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) 
        {   
            $choosedColor = $entityManager->getRepository(Color::class)->findOneBy(['id'=>$color]);

            if ($choosedColor == null) {
                $this->addFlash('Attention', "Sélectionnez une couleur");

                $route = $request->headers->get('referer');

                return $this->redirect($route);
            }
    
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

            // If pour savoir si le produit en question est deja dans le panier
            if ($cart != null) {
                $cartProducts = $cart->getCartProduct()->toArray();
                foreach ($cartProducts as $cartProduct) {

                    if ($cartProduct->getBijoux() !== null) {

                        if ($cartProduct->getBijoux()->getId() == $bijou[0]->getId()
                            && $cartProduct->getcolor() == $choosedColor) {

                            $cartProduct->setQuantity($cartProduct->getQuantity() + $form->get('quantity')->getData());

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

                            return $this->redirectToRoute('added_product');
                        }
                    }
                }
            }

            $cartProduct= new CartProduct();
     
            $cartProduct->setCreatedAt(new DateTime());
            $cartProduct->setUpdatedAt(new DateTime());
            $cartProduct->setBijoux($bijou[0]);
            $quantity = $form->get('quantity')->getData();
            $cartProduct->setQuantity($quantity);
            $cartProduct->setPrice($bijou[0]->getPrice());
            $cartProduct->setTitle($bijou[0]->getTitle());
            $cartProduct->setPhoto($bijou[0]->getPhoto());
            $cartProduct->setColor($entityManager->getRepository(Color::class)->findOneBy(['id'=>$color]));
            $cartProduct->setSubCategory($bijou[0]->getSousCategorie());

            $sku = $entityManager->getRepository(BijouxQuantity::class)->findOneBy([
                'bijoux' => $bijou[0]->getId(), 
                'color' => $color,
            ])->getSku();

            $cartProduct->setSku($sku);

            $entityManager->persist($cartProduct);
            
            $cart->setUpdatedAt(new DateTime());     
            $cart->setUser($user);
            $cart->addCartProduct($cartProduct);
            // $cart->setTotalPrice($cart->getTotalPrice() + $quantity * $bijou[0]->getPrice());

            $token = $cart->getToken();

            if ($token == null) {
                $cart->setToken($request->getSession()->get('id'));
            } else {
                $cart->setToken($cart->getToken());
            }
            
        //   dd($cart);
            $entityManager->persist($cart);
            $entityManager->flush();

            return $this->redirectToRoute('added_product');
        }
        
        $similarItm = $entityManager->getRepository(Bijoux::class)->findSimilarItem($bijou[0]->getCategorie(), $bijou[0]->getSousCategorie());

        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findBy(['user' => $this->getUser(), 'bijoux' => $bijoux]);

        return $this->render('voir_bijoux/v_bijoux.html.twig', [
            'bijou' => $bijou,
            'bijouxVariations' => $bijouxVariations,
            'bijouxVariationsJs' => json_encode($bijouxVariations),
            'couleurs' => $couleurs,
            'expedition' => $expedition,
            'form' => $form->createView(),
            'similarItm' => $similarItm,
            'userFavorites' => $userFavorites
        ]);
    }

}
