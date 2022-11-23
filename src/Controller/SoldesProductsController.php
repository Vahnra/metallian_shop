<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\CategorieMerchandising;
use App\Form\AllFilterFormType;
use App\Service\ProductsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SoldesProductsController extends AbstractController
{
    #[Route('/soldes', name: 'show_solde_products')]
    public function showSoldeProducts(
        EntityManagerInterface $entityManager,
        ProductsService $productsService,
        Request $request): Response
    {
        $filterForm = $this->createForm(AllFilterFormType::class)->handleRequest($request);

        $products = $productsService->getPaginatedSoldesProducts();

        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        $categoriesMerchandising = $entityManager->getRepository(CategorieMerchandising::class)->findAll();

        // Si le formulair de filtre est soumit, il filtre
        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterForm->get('Couleur')->getData();

            $size = $filterForm->get('Size')->getData();

            $material = $filterForm->get('material')->getData();

            $marque = $filterForm->get('marque')->getData();

            $artist = $filterForm->get('artist')->getData();

            $musicType = $filterForm->get('musicType')->getData();

            $priceMini = $filterForm->get('priceMini')->getData();

            $priceMax = $filterForm->get('priceMax')->getData();

            // On fait appelle au qb par les repo
            $products = $productsService->getPaginatedSoldesProductsFiltered(
                $color,
                $size,
                $material,
                $marque,
                $artist,
                $musicType,
                $priceMini,
                $priceMax
            );
        }

        return $this->render('soldes_products/soldes.html.twig', [
            'newProducts' => $products,
            'categories' => $categories,
            'categoriesMerchandising' => $categoriesMerchandising,
            'filterForm' => $filterForm->createView()
        ]);
    }
}
