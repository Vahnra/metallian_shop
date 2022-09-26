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
use Doctrine\ORM\EntityManager;
use App\Form\CartProductFormType;
use App\Entity\AccessoiresMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AccessoiresMerchandisingQuantity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirAccessoriesMerchController extends AbstractController
{
    #[Route('/voir/accessoires/merch-{id}', name: 'voir_accessoires_merch', methods:['GET', 'POST'])]
    public function index(
        AccessoiresMerchandising $accessoiresMerches,
        EntityManagerInterface $entityManager,
        Request $request
        ): Response
    {
        $color = $request->get('color');

        $size = $request->get('size');

        $accessoiresMerch = $entityManager->getRepository(AccessoiresMerchandising::class)->findBy(['id'=>$accessoiresMerches->getId()]);

        $accessoiresVariations = $entityManager->getRepository(AccessoiresMerchandisingQuantity::class)->findBy(['accessoiresMerchandising' => $accessoiresMerch[0]->getId()]);

        $couleurs = [];

        $sizes = [];

        foreach ($accessoiresVariations as $acc) {
            if (!in_array($acc->getColor(), $couleurs, true)) {
                array_push($couleurs, $acc->getColor());
            }
        }

        foreach ($accessoiresVariations as $acc) {
            if (!in_array($acc->getSize(), $sizes, true)) {
                array_push($sizes, $acc->getSize());
            }
        }
        
        $material = $entityManager->getRepository(Material::class)->findBy(['id'=>$accessoiresMerch[0]->getMaterial()]);

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
            $cartProduct->setAccessoiresMerchandising($accessoiresMerch[0]);
            $quantity = $form->get('quantity')->getData();
            $cartProduct->setQuantity($quantity);
            $cartProduct->setPrice($accessoiresMerch[0]->getPrice());
            $cartProduct->setTitle($accessoiresMerch[0]->getTitle());
            $cartProduct->setPhoto($accessoiresMerch[0]->getPhoto());
            $cartProduct->setColor($entityManager->getRepository(Color::class)->findOneBy(['id'=>$color]));
            $cartProduct->setSize($entityManager->getRepository(Size::class)->findOneBy(['id'=>$size]));
            $cartProduct->setSubCategory($accessoiresMerch[0]->getSousCategorieMerchandising());
            
            $sku = $entityManager->getRepository(AccessoiresMerchandisingQuantity::class)->findOneBy([
                'accessoiresMerchandising' => $accessoiresMerch[0]->getId(), 
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

        $similarItm = $entityManager->getRepository(AccessoiresMerchandising::class)->findBy([
            'sousCategorieMerchandising' => $accessoiresMerch[0]->getSousCategorieMerchandising(),
            'categorieMerchandising' => $accessoiresMerch[0]->getCategorieMerchandising(),
        ]);

        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findBy(['user' => $this->getUser(), 'accessoiresMerchandising' => $accessoiresMerches]);

        return $this->render('voir_accessories_merch/accessoriesMerch.html.twig', [
            'accessoriesMerch' => $accessoiresMerch,
            'accessoiresVariations' => $accessoiresVariations,
            'accessoiresVariationsJs' => json_encode($accessoiresVariations),
            'material' => $material,
            'expedition' => $expedition,
            'similarItm' => $similarItm,
            'couleurs' => $couleurs,
            'sizes' => $sizes,
            'form' => $form->createView(),
            'userFavorites' => $userFavorites
        ]);
    }
}
