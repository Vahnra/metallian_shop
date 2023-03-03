<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Material;
use App\Entity\Products;
use App\Entity\Expedition;
use App\Entity\CartProduct;
use App\Entity\FavoriteProduct;
use App\Entity\Images;
use App\Form\CartProductFormType;
use App\Entity\ProductsQuantities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ViewProductsController extends AbstractController
{
    #[Route('/article-{id}', name: 'view_products', methods:['GET', 'POST'])]
    public function viewProducts(
        Products $products,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $color = $request->get('color');

        $size = $request->get('size');

        $products = $entityManager->getRepository(Products::class)->findOneBy(['id' => $products->getId()]);

        $productsVariations = $entityManager->getRepository(ProductsQuantities::class)->findBy(['products' => $products->getId(), 'solde' => null]);

        $couleurs = [];

        $sizes = [];

        foreach ($productsVariations as $acc) {
            if (!in_array($acc->getColor(), $couleurs, true)) {
                array_push($couleurs, $acc->getColor());
            }
        }

        foreach ($productsVariations as $acc) {
            if (!in_array($acc->getSize(), $sizes, true)) {
                array_push($sizes, $acc->getSize());
            }
        }
        
        $material = $entityManager->getRepository(Material::class)->findBy(['id' => $products->getMaterial()]);

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $form = $this->createForm(CartProductFormType::class, ['qty' => $productsVariations[0]->getStock()])->handleRequest($request);

        $user = $this->getUser();


        if ($form->isSubmitted() && $form->isValid()) 
        {   
            $choosedColor = $entityManager->getRepository(Color::class)->findOneBy(['id'=>$color]);

            if ($choosedColor == null && $products->getCategorie()->getTitle() !== "CDs" && $products->getCategorie()->getTitle() !== "Vyniles") {
                $this->addFlash('Attention', "Sélectionnez une couleur");

                $route = $request->headers->get('referer');

                return $this->redirect($route);
            }

            $choosedSize = $entityManager->getRepository(Size::class)->findOneBy(['id'=>$size]);

            if ($choosedColor == null && $products->getCategorie()->getTitle() !== "CDs" && $products->getCategorie()->getTitle() !== "Vyniles") {
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

            // If pour savoir si le produit en question est deja dans le panier
            if ($cart != null) {
                $cartProducts = $cart->getCartProduct()->toArray();
                foreach ($cartProducts as $cartProduct) {

                    if ($cartProduct->getProducts() !== null) {

                        if ($cartProduct->getProducts()->getId() == $products->getId() 
                            && $cartProduct->getSize() == $choosedSize 
                            && $cartProduct->getcolor() == $choosedColor) {

                            $cartProduct->setQuantity($cartProduct->getQuantity() + $form->get('quantity')->getData());
                            $cartProduct->setUpdatedAt(new DateTime());

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

                            return $this->redirectToRoute('view_products',[
                                'id' => $products->getId(),
                                'colorAdded' => $cartProduct->getColor(),
                                'sizeAdded' => $cartProduct->getSize(),
                                'quantityAdded' => $cartProduct->getQuantity(),
                                'totalPrice' => $cartProduct->getPrice(),
                                'success' => 'success'
                            ]);
                        }
                    }
                }
            }

            $cartProduct= new CartProduct();
   
            $cartProduct->setCreatedAt(new DateTime());
            $cartProduct->setUpdatedAt(new DateTime());
            $cartProduct->setProducts($products);
            $quantity = $form->get('quantity')->getData();
            $cartProduct->setQuantity($quantity);
            $cartProduct->setPrice($products->getPrice());
            $cartProduct->setTitle($products->getTitle());
            $cartProduct->setPhoto($products->getImages()->getValues()[0]->getImage());
            if ($choosedColor !== null) {
                $cartProduct->setColor($choosedColor);
            }
            if ($choosedSize !== null) {
                $cartProduct->setSize($choosedSize);
            }
            
            if ($products->getCategorie()->getTitle() !== "CDs" && $products->getCategorie()->getTitle() !== "Vyniles") {

                if ($products->getSousCategorie() != null) {
                    $cartProduct->setSubCategory($products->getSousCategorie());
                } else {
                    $cartProduct->setSubCategory($products->getSousCategorieMerchandising());
                }
            }         

            $sku = $entityManager->getRepository(ProductsQuantities::class)->findOneBy([
                'products' => $products->getId(), 
                'color' => $color,
                'size' => $size
            ])->getSku();

            $cartProduct->setSku($sku);

            $entityManager->persist($cartProduct);
            
            $cart->setUpdatedAt(new DateTime());     
            $cart->setUser($user);
            $cart->addCartProduct($cartProduct);
            // $cart->setTotalPrice($cart->getTotalPrice() + $quantity * $vetement->getPrice());

            $token = $cart->getToken();

            if ($token == null) {
                $cart->setToken($request->getSession()->get('id'));
            } else {
                $cart->setToken($cart->getToken());
            }

            $entityManager->persist($cart);
            $entityManager->flush();

            return $this->redirectToRoute('view_products',[
                'id' => $products->getId(),
                'colorAdded' => $cartProduct->getColor(),
                'sizeAdded' => $cartProduct->getSize(),
                'quantityAdded' => $cartProduct->getQuantity(),
                'totalPrice' => $cartProduct->getPrice(),
                'success' => 'success'
            ]);
        }

        $categorie = $products->getCategorie();

        $sousCategorie = $products->getSousCategorie();

        $similarItm = $entityManager->getRepository(Products::class)->findSimilarItem($categorie, $sousCategorie);

        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findBy(['user' => $this->getUser(), 'products' => $products]);

        $images = $entityManager->getRepository(Images::class)->findby(['product' => $products]);
        
        return $this->render('view_products/view_products.html.twig', [
            'success' => 0,
            'vetement' => $products,
            'images' => $images,
            'vetementVariations' => $productsVariations,
            'vetementVariationsJs' => json_encode($productsVariations),
            'couleurs' => $couleurs,
            'sizes' => $sizes,
            'material' => $material,
            'expedition' => $expedition,
            'form' => $form->createView(),
            'similarItm' => $similarItm,
            'userFavorites' => $userFavorites
        ]);
    }

    #[Route('/soldes/article/{id}', name: 'view_solded_products', methods:['GET', 'POST'])]
    public function viewSoldedProducts(
        Products $products,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $color = $request->get('color');

        $size = $request->get('size');

        $products = $entityManager->getRepository(Products::class)->findOneBy(['id' => $products->getId()]);

        $productsVariations = $entityManager->getRepository(ProductsQuantities::class)->findBy(['products' => $products->getId(), 'solde' => 'yes']);

        $couleurs = [];

        $sizes = [];

        foreach ($productsVariations as $acc) {
            if (!in_array($acc->getColor(), $couleurs, true)) {
                array_push($couleurs, $acc->getColor());
            }
        }

        foreach ($productsVariations as $acc) {
            if (!in_array($acc->getSize(), $sizes, true)) {
                array_push($sizes, $acc->getSize());
            }
        }
        
        $material = $entityManager->getRepository(Material::class)->findBy(['id' => $products->getMaterial()]);

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

            // If pour savoir si le produit en question est deja dans le panier
            if ($cart != null) {
                $cartProducts = $cart->getCartProduct()->toArray();
                foreach ($cartProducts as $cartProduct) {

                    if ($cartProduct->getProducts() !== null) {

                        if ($cartProduct->getProducts()->getId() == $products->getId() 
                            && $cartProduct->getSize() == $choosedSize 
                            && $cartProduct->getcolor() == $choosedColor) {

                            $cartProduct->setQuantity($cartProduct->getQuantity() + $form->get('quantity')->getData());
                            $cartProduct->setUpdatedAt(new DateTime());

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

                            return $this->redirectToRoute('view_solded_products',[
                                'id' => $products->getId(),
                                'colorAdded' => $cartProduct->getColor(),
                                'sizeAdded' => $cartProduct->getSize(),
                                'quantityAdded' => $cartProduct->getQuantity(),
                                'totalPrice' => $cartProduct->getPrice(),
                                'success' => 'success'
                            ]);
                        }
                    }
                }
            }

            $cartProduct= new CartProduct();
   
            $cartProduct->setCreatedAt(new DateTime());
            $cartProduct->setUpdatedAt(new DateTime());
            $cartProduct->setProducts($products);
            $quantity = $form->get('quantity')->getData();
            $cartProduct->setQuantity($quantity);

            $choosedArticle = $entityManager->getRepository(ProductsQuantities::class)->findOneBy(['color' => $choosedColor, 'size' => $choosedSize, 'solde' => 'yes']);

            $cartProduct->setPrice($choosedArticle->getDiscount());
            $cartProduct->setTitle($products->getTitle());
            $cartProduct->setPhoto($products->getImages()->getValues()[0]->getImage());
            $cartProduct->setColor($choosedColor);
            $cartProduct->setSize($choosedSize);
            if ($products->getSousCategorie() != null) {
                $cartProduct->setSubCategory($products->getSousCategorie());
            } else {
                $cartProduct->setSubCategory($products->getSousCategorieMerchandising());
            }
            

            $sku = $entityManager->getRepository(ProductsQuantities::class)->findOneBy([
                'products' => $products->getId(), 
                'color' => $color,
                'size' => $size
            ])->getSku();

            $cartProduct->setSku($sku);

            $entityManager->persist($cartProduct);
            
            $cart->setUpdatedAt(new DateTime());     
            $cart->setUser($user);
            $cart->addCartProduct($cartProduct);
            // $cart->setTotalPrice($cart->getTotalPrice() + $quantity * $vetement->getPrice());

            $token = $cart->getToken();

            if ($token == null) {
                $cart->setToken($request->getSession()->get('id'));
            } else {
                $cart->setToken($cart->getToken());
            }

            $entityManager->persist($cart);
            $entityManager->flush();

            return $this->redirectToRoute('view_solded_products',[
                'id' => $products->getId(),
                'colorAdded' => $cartProduct->getColor(),
                'sizeAdded' => $cartProduct->getSize(),
                'quantityAdded' => $cartProduct->getQuantity(),
                'totalPrice' => $cartProduct->getPrice(),
                'success' => 'success'
            ]);
        }

        $categorie = $products->getCategorie();

        $sousCategorie = $products->getSousCategorie();

        $similarItm = $entityManager->getRepository(Products::class)->findSimilarItem($categorie, $sousCategorie);

        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findBy(['user' => $this->getUser(), 'products' => $products]);

        $images = $entityManager->getRepository(Images::class)->findby(['product' => $products]);

        return $this->render('view_products/view_solde_products.html.twig', [
            'success' => 0,
            'vetement' => $products,
            'images' => $images,
            'vetementVariations' => $productsVariations,
            'vetementVariationsJs' => json_encode($productsVariations),
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
