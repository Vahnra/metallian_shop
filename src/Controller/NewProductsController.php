<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Bijoux;
use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\Chaussures;
use App\Entity\Accessoires;
use App\Entity\VetementMerchandising;
use App\Entity\CategorieMerchandising;
use App\Entity\AccessoiresMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewProductsController extends AbstractController
{
    #[Route('/nouveautes', name: 'new_products', methods:['GET', 'POST'])]
    public function index(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        PaginatorInterface $paginator,
    ): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        $categoriesMerchandising = $entityManager->getRepository(CategorieMerchandising::class)->findAll();

        $newVetements = $entityManager->getRepository(Vetement::class)->newProducts();
        $newVetementsMerchandising = $entityManager->getRepository(VetementMerchandising::class)->newProducts();
        $newMedias = $entityManager->getRepository(Media::class)->newProducts();
        $newChaussures = $entityManager->getRepository(Chaussures::class)->newProducts();
        $newBijoux = $entityManager->getRepository(Bijoux::class)->newProducts();
        $newAccessoires = $entityManager->getRepository(Accessoires::class)->newProducts();
        $newAccessoiresMerchandising = $entityManager->getRepository(AccessoiresMerchandising::class)->newProducts();

        $newProducts = array_merge($newVetements, $newVetementsMerchandising, $newMedias, $newChaussures, $newBijoux, $newAccessoires, $newAccessoiresMerchandising);

        $requestStack = $requestStack->getMainRequest();   

        $page = $requestStack->query->getInt('page', 1);

        $searchResults = $paginator->paginate($newProducts, $page, 5);


        return $this->render('new_products/new_products.html.twig', [
            'newProducts' => $searchResults,
            'categories' => $categories,
            'categoriesMerchandising' => $categoriesMerchandising
        ]);
    }

}
