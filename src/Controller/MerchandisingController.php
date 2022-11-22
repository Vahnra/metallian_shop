<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Marques;
use App\Entity\Material;
use App\Entity\MusicType;
use App\Entity\CategorieMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SousCategorieMerchandising;
use App\Service\VetementMerchandisingService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AccessoiresMerchandisingService;
use App\Form\VetementMerchandisingFilterFormType;
use App\Form\AccessoiresMerchandisingFilterFormType;
use App\Repository\ProductsRepository;
use App\Service\ProductsService;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MerchandisingController extends AbstractController
{
    #[Route('/merchandising-{title}', name: 'show_from_category_merchandising', methods:['GET', 'POST'])]
    public function showFromCategoryMerchandising(
        CategorieMerchandising $categorieMerchandising,
        ProductsService $productsService,
        EntityManagerInterface $entityManager,
        Request $request
        ): Response
    {
        // Form pour le filtre vetement merchandising
        $filterForm = $this->createForm(VetementMerchandisingFilterFormType::class)->handleRequest($request);

        // Par défaut la pagination renvoit tout
        $products = $productsService->getPaginatedProductsMerchandising($categorieMerchandising);

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
            $products = $productsService->getPaginatedProductsMerchandisingFiltered(
                $categorieMerchandising, 
                $color, 
                $size, 
                $material, 
                $marque,
                $artist,
                $priceMini, 
                $priceMax
            );        
        }
        
        // On récupère les sous catégories de la catégories en question
        $souscategories = $entityManager->getRepository(SousCategorieMerchandising::class)->findAll();

        return $this->render('category/show_from_category_merchandising.html.twig', [
            'categories' => $categorieMerchandising,
            'souscategories' => $souscategories,
            'products' => $products,
            'filterForm' => $filterForm->createView(),
        ]);
    }

    #[Route('/merchandising-{title1}/{title}', name:'show_merchandising_sous_categorie', methods:['GET', 'POST'])]
    public function showMerchandisingSousCategorie(
        SousCategorieMerchandising $souscategories,
        ProductsService $productsService,
        VetementMerchandisingService $vetementMerchandisingService,
        AccessoiresMerchandisingService $accessoiresService,
        EntityManagerInterface $entityManager,
        Request $request
        ): Response 
    {
        $categorieMerchandising = $entityManager->getRepository(CategorieMerchandising::class)->findOneBy(['title' => $request->get('title1')]);

        // Form pour le filtre vetement merchandising
        $filterForm = $this->createForm(VetementMerchandisingFilterFormType::class)->handleRequest($request);

        // Par défaut la pagination renvoit tout
        $vetements = $vetementMerchandisingService->getPaginatedVetementsSousCategorie($souscategories);

        $accessoires = $accessoiresService->getPaginatedAccessoiresSousCategorie($souscategories);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterForm->get('Couleur')->getData();

            $size = $filterForm->get('Size')->getData();

            $material = $filterForm->get('material')->getData();

            $marque = $filterForm->get('marque')->getData();

            $priceMini = $filterForm->get('priceMini')->getData();

            $priceMax = $filterForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $vetements = $vetementMerchandisingService->getPaginatedVetementsSousCategoriesFiltered(
                $souscategories, 
                $color, 
                $size, 
                $material, 
                $marque, 
                $priceMax, 
                $priceMini
            );        

        }

        $allsouscategories = $entityManager->getRepository(SousCategorieMerchandising::class)->findAll();

        return $this->render("sous_category/show_merchandising_sous_category.html.twig", [
            'categories' => $categorieMerchandising,
            'souscategories' => $souscategories,
            'allsouscategories' => $allsouscategories,
            'vetements' => $vetements,
            'accessoires' => $accessoires,
            'filterForm' => $filterForm->createView(),
        ]);
    }
}
