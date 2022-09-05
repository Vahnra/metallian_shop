<?php

namespace App\Controller;

use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Repository\VetementRepository;
use App\Service\BijouxService;
use App\Service\VetementService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/produits-{title}', name: 'show_vetements_from_category', methods:['GET'])]
    public function showVetementsFromCategorie(Categorie $categories, EntityManagerInterface $entityManager, VetementService $vetementService, BijouxService $bijouxService): Response
    {
        // Fonction repo pour pagination
        $vetements = $vetementService->getPaginatedVetements($categories);
        $bijoux = $bijouxService->getPaginatedBijoux($categories);

        // On récupère les sous catégories de la catégories en question
        $souscategories = $entityManager->getRepository(SousCategorie::class)->findAll();

        return $this->render("category/show_vetements_from_category.html.twig", [
            'vetements' => $vetements,
            'bijoux' => $bijoux,
            'categories' => $categories,
            'souscategories' => $souscategories
        ]);
    }
}
