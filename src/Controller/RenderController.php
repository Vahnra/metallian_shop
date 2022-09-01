<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RenderController extends AbstractController
{
    #[Route('/categories1', name: 'render_categories_in_nav')]
    public function renderCategoriesInNav(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findBy(['deletedAt'=> null]);

        return $this->render('rendered/categories_in_nav.html.twig', [
            'categories' => $categories
        ]);
    }
}
