<?php

namespace App\Controller;

use App\Entity\Marques;
use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\VetementMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BrandsController extends AbstractController
{
    #[Route('/marques', name: 'show_brands')]
    public function showBrands(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        PaginatorInterface $paginator
        ): Response
    {
        $brandsArticles = $entityManager->getRepository(Marques::class)->findAll();

        $vetements = $entityManager->getRepository(Vetement::class)->brandsProducts();

        $vetementsMerchandising = $entityManager->getRepository(VetementMerchandising::class)->brandsProducts();

        $allArticlesArray = array_merge($vetements, $vetementsMerchandising,);

        $requestStack = $requestStack->getMainRequest();   

        $page = $requestStack->query->getInt('page', 1);

        $allArticles = $paginator->paginate($allArticlesArray, $page, 5, array('defaultSortFieldName' => 'a.createdAt', 'defaultSortDirection' => 'desc'));

        return $this->render('brands/show_brands.html.twig', [
            'brandsArticles' => $brandsArticles,
            'allArticles' => $allArticles
        ]);
    }
}
