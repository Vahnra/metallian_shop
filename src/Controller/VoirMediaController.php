<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\Media;
use App\Entity\Artist;
use App\Entity\Categorie;
use App\Entity\MusicType;
use App\Entity\Expedition;
use App\Entity\CartProduct;
use App\Entity\MediaQuantity;
use App\Entity\SousCategorie;
use App\Entity\FavoriteProduct;
use App\Form\CartProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirMediaController extends AbstractController
{
    #[Route('/article-media-{id}', name: 'voir_media', methods:['GET', 'POST'])]
    public function voirMedia(
        Media $media, 
        EntityManagerInterface $entityManager,
        Request $request
        ): Response
    {
        $media = $entityManager->getRepository(Media::class)->findOneBy(['id'=>$media->getId()]);

        $mediaVariations = $entityManager->getRepository(MediaQuantity::class)->findBy(['media' => $media->getId()]);

        $artist = $entityManager->getRepository(Artist::class)->findBy(['id'=>$media->getArtist()]);
        
        $musicType = $entityManager->getRepository(MusicType::class)->findBy(['id'=>$media->getGenre()]);

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $similarCategory = $entityManager->getRepository(SousCategorie::class)->findBy([
            'id' => $media->getSousCategorie()  
        ]);

        $similarItm = $entityManager->getRepository(Media::class)->findBy([
            'sousCategorie' => $media->getSousCategorie()
           
        ]);

        $similaeGnr = $entityManager->getRepository(Media::class)->findBy([
            'genre' => $media->getGenre()
            
        ]);

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

            // If pour savoir si le produit en question est deja dans le panier
            if ($cart != null) {
                $cartProducts = $cart->getCartProduct()->toArray();
                foreach ($cartProducts as $cartProduct) {

                    if ($cartProduct->getMedia() !== null) {

                        if ($cartProduct->getMedia()->getId() == $media->getId()) {

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
            $cartProduct->setMedia($media);
            $quantity = $form->get('quantity')->getData();
            $cartProduct->setQuantity($quantity);
            $cartProduct->setPrice($media->getPrice());
            $cartProduct->setTitle($media->getTitle());
            $cartProduct->setPhoto($media->getPhoto1());
            $cartProduct->setSubCategory($media->getSousCategorie());

            $sku = $entityManager->getRepository(MediaQuantity::class)->findOneBy([
                'media' => $media->getId(), 
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
     
            $entityManager->persist($cart);
            $entityManager->flush();

            return $this->redirectToRoute('added_product');
        }
    
        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findBy(['user' => $this->getUser(), 'media' => $media]);

        return $this->render('voir_media/voir_media.html.twig', [
            'media' => $media,
            'bijouxVariations' => $mediaVariations,
            'bijouxVariationsJs' => json_encode($mediaVariations),
            'artist' => $artist,
            'musicType' => $musicType,
            'expedition' => $expedition,
            'similarItm' => $similarItm,
            'similaeGnr' => $similaeGnr,
            'userFavorites' => $userFavorites,
            'form' => $form->createView(),
        ]);
    }

       
        
   
}
