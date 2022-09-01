<?php

namespace App\Controller;

use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Repository\VetementRepository;
use App\Service\VetementService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/vetements-{title}', name: 'show_vetements_from_category', methods:['GET'])]
    public function showVetementsFromCategorie(Categorie $categories, EntityManagerInterface $entityManager, VetementService $vetementService): Response
    {
        // Fonction repo pour pagination
        $vetements = $vetementService->getPaginatedVetements($categories);

        // On récupère les sous catégories de la catégories en question
        $souscategories = $entityManager->getRepository(SousCategorie::class)->findAll();

        return $this->render("category/show_vetements_from_category.html.twig", [
            'vetements' => $vetements,
            'categories' => $categories,
            'souscategories' => $souscategories
        ]);
    }
}
