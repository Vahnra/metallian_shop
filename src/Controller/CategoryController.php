<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Form\MediaFilterFormType;
use App\Form\BijouxFilterFormType;
use App\Form\VetementFilterFormType;
use App\Form\ChaussuresFilterFormType;
use App\Form\AccessoiresFilterFormType;
use App\Service\ProductsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/articles-{title}', name: 'show_vetements_from_category', methods:['GET', 'POST'])]
    public function showVetementsFromCategorie(
        Categorie $categories, 
        EntityManagerInterface $entityManager,
        ProductsService $productsService,
        Request $request
        ): Response
    {
        // Form pour le filtre
        $filterForm = $this->createForm(VetementFilterFormType::class)->handleRequest($request);

        // Form pour le filtre bijoux
        $filterBijouxForm = $this->createForm(BijouxFilterFormType::class)->handleRequest($request);

        // Form pour le filter chaussures
        $filterChaussuresForm = $this->createForm(ChaussuresFilterFormType::class)->handleRequest($request);

        // Form pour le filter accessoires
        $filterAccessoiresForm = $this->createForm(AccessoiresFilterFormType::class)->handleRequest($request);

        // Form pour le filter media
        $filterMediaForm = $this->createForm(MediaFilterFormType::class)->handleRequest($request);

        // Par défaut la pagination renvoit tout
        $products = $productsService->getPaginatedProducts($categories);

        // Si le formulair de filtre est soumit, il filtre
        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterForm->get('Couleur')->getData();            

            $size = $filterForm->get('Size')->getData();

            $material = $filterForm->get('material')->getData();

            $marque = $filterForm->get('marque')->getData();

            $artist = $filterForm->get('artist')->getData();

            $priceMini = $filterForm->get('priceMini')->getData();

            $priceMax = $filterForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $products = $productsService->getPaginatedVetementsFilteredByColor(
                $categories, 
                $color, 
                $size, 
                $material, 
                $marque,
                $artist,
                $priceMax, 
                $priceMini
            );        

        }    

        if ($filterBijouxForm->isSubmitted() && $filterBijouxForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterBijouxForm->get('Couleur')->getData();

            $priceMini = $filterBijouxForm->get('priceMini')->getData();

            $priceMax = $filterBijouxForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $products = $productsService->getPaginatedBijouxFiltered(
                $categories, 
                $color, 
                $priceMax, 
                $priceMini
            );        
        }    

        if ($filterAccessoiresForm->isSubmitted() && $filterAccessoiresForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterAccessoiresForm->get('Couleur')->getData();

            $material = $filterAccessoiresForm->get('material')->getData();

            $priceMini = $filterAccessoiresForm->get('priceMini')->getData();

            $priceMax = $filterAccessoiresForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $products = $productsService->getPaginatedAccessoiresFiltered(
                $categories, 
                $color, 
                $material, 
                $priceMax, 
                $priceMini
            );        
        }  

        if ($filterChaussuresForm->isSubmitted() && $filterChaussuresForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterChaussuresForm->get('Couleur')->getData();

            $size = $filterChaussuresForm->get('Size')->getData();

            $material = $filterChaussuresForm->get('material')->getData();

            $priceMini = $filterChaussuresForm->get('priceMini')->getData();

            $priceMax = $filterChaussuresForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $products = $productsService->getPaginatedChaussuresFiltered(
                $categories, 
                $color, 
                $size, 
                $material, 
                $priceMax, 
                $priceMini
            );        
        }  

        if ($filterMediaForm->isSubmitted() && $filterMediaForm->isValid()) {
            // on prend les valeurs du formulaire
            $musicType = $filterMediaForm->get('musicType')->getData();

            $priceMini = $filterMediaForm->get('priceMini')->getData();

            $priceMax = $filterMediaForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $products = $productsService->getPaginatedMediaFiltered(
                $categories, 
                $musicType,
                $priceMax, 
                $priceMini
            );        
        }  

        // On récupère les sous catégories de la catégories en question
        $souscategories = $entityManager->getRepository(SousCategorie::class)->findAll();

        return $this->render("category/show_vetements_from_category.html.twig", [
            'products' => $products,
            'categories' => $categories,
            'souscategories' => $souscategories,
            'filterForm' => $filterForm->createView(),
            'filterBijouxForm' => $filterBijouxForm->createView(),
            'filterChaussuresForm' => $filterChaussuresForm->createView(),
            'filterAccessoiresForm' => $filterAccessoiresForm->createView(),
            'filterMediaForm' => $filterMediaForm->createView(),
        ]);
    }
}
