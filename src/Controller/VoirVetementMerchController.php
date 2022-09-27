<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Material;
use App\Entity\Expedition;
use App\Entity\CartProduct;
use App\Entity\FavoriteProduct;
use App\Form\CartProductFormType;
use App\Entity\VetementMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\VetementMerchandisingQuantity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirVetementMerchController extends AbstractController
{
    #[Route('/voir/vetement/merch-{id}', name: 'voir_vetement_merch', methods:['GET', 'POST'])]
    public function index(
        VetementMerchandising $vetementMerches,
        EntityManagerInterface $entityManager,
        Request $request
        ): Response
    {
        $color = $request->get('color');

        $size = $request->get('size');

        $vetementMerche = $entityManager->getRepository(VetementMerchandising::class)->findBy(['id'=>$vetementMerches->getId()]);

        $vetementVariations = $entityManager->getRepository(VetementMerchandisingQuantity::class)->findBy(['vetementMerchandising' => $vetementMerche[0]->getId()]);

        $couleurs = [];

        $sizes = [];

        foreach ($vetementVariations as $acc) {
            if (!in_array($acc->getColor(), $couleurs, true)) {
                array_push($couleurs, $acc->getColor());
            }
        }

        foreach ($vetementVariations as $acc) {
            if (!in_array($acc->getSize(), $sizes, true)) {
                array_push($sizes, $acc->getSize());
            }
        }
        
        $material = $entityManager->getRepository(Material::class)->findBy(['id'=>$vetementMerche[0]->getMaterial()]);

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $cartProduct= new CartProduct();

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

            $choosedSize = $entityManager->getRepository(Size::class)->findOneBy(['id'=>$size]);

            if ($choosedSize == null) {
                $this->addFlash('Attention', "Sélectionnez une taille");

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
            
            $cartProduct->setCreatedAt(new DateTime());
            $cartProduct->setUpdatedAt(new DateTime());
            $cartProduct->setVetementMerchandising($vetementMerche[0]);
            $quantity = $form->get('quantity')->getData();
            $cartProduct->setQuantity($quantity);
            $cartProduct->setPrice($vetementMerche[0]->getPrice());
            $cartProduct->setTitle($vetementMerche[0]->getTitle());
            $cartProduct->setPhoto($vetementMerche[0]->getPhoto());
            $cartProduct->setColor($entityManager->getRepository(Color::class)->findOneBy(['id'=>$color]));
            $cartProduct->setSize($entityManager->getRepository(Size::class)->findOneBy(['id'=>$size]));
            $cartProduct->setSubCategory($vetementMerche[0]->getSousCategorieMerchandising());         

            $sku = $entityManager->getRepository(VetementMerchandisingQuantity::class)->findOneBy([
                'vetementMerchandising' => $vetementMerche[0]->getId(), 
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

            $entityManager->persist($cart);
            $entityManager->flush();

        }

        $similarItm = $entityManager->getRepository(VetementMerchandising::class)->findSimilarItem($vetementMerche[0]->getCategorieMerchandising(), $vetementMerche[0]->getSousCategorieMerchandising());

        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findBy(['user' => $this->getUser(), 'vetementMerchandising' => $vetementMerches]);

        return $this->render('voir_vetement_merch/VoirVetementMerch.html.twig', [
            'vetementMerche' => $vetementMerche,
            'vetementVariations' => $vetementVariations,
            'vetementVariationsJs' => json_encode($vetementVariations),
            'couleurs' => $couleurs,
            'sizes' => $sizes,
            'material' => $material,
            'expedition' => $expedition,
            'form' => $form->createView(),
            'similarItm' => $similarItm,
            'userFavorites' => $userFavorites
        ]);
    }
}
