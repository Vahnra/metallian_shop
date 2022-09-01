<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Entity\CategorieMerchandising;
use App\Entity\SousCategorieMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RenderController extends AbstractController
{
    #[Route('/categories1', name: 'render_categories_in_nav')]
    public function renderCategoriesInNav(EntityManagerInterface $entityManager): Response
    {
        // On récupère toutes les categories et sous categories normaux
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        $souscategories = $entityManager->getRepository(SousCategorie::class)->findAll();

        // On récupre toutes les categoriesMerchandising et sousCategoriesMerchandising
        $categoriesMerchandising = $entityManager->getRepository(CategorieMerchandising::class)->findAll();

        $souscategoriesMerchandising = $entityManager->getRepository(SousCategorieMerchandising::class)->findAll();

        return $this->render('rendered/categories_in_nav.html.twig', [
            'categories' => $categories,
            'souscategories' => $souscategories,
            'categoriesMerchandising' => $categoriesMerchandising,
            'souscategoriesMerchandising' => $souscategoriesMerchandising
        ]);
    }

  

}
