<?php

namespace App\Controller;

use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Service\MediaService;
use App\Service\BijouxService;
use App\Service\VetementService;
use App\Repository\VetementRepository;
use App\Service\AccessoiresService;
use App\Service\ChaussuresService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/produits-{title}', name: 'show_vetements_from_category', methods:['GET'])]
    public function showVetementsFromCategorie(
        Categorie $categories, 
        EntityManagerInterface $entityManager, 
        VetementService $vetementService, 
        BijouxService $bijouxService, 
        MediaService $mediaService,
        ChaussuresService $chaussuresService,
        AccessoiresService $accessoiresService,

        ): Response
    {
        // Fonction repo pour pagination
        $vetements = $vetementService->getPaginatedVetements($categories);

        $bijoux = $bijouxService->getPaginatedBijoux($categories);

        $medias = $mediaService->getPaginatedMedias($categories);

        $chaussures = $chaussuresService->getPaginatedChaussures($categories);

        $accessoires = $accessoiresService->getPaginatedAccessoires($categories);

        // On récupère les sous catégories de la catégories en question
        $souscategories = $entityManager->getRepository(SousCategorie::class)->findAll();

        return $this->render("category/show_vetements_from_category.html.twig", [
            'vetements' => $vetements,
            'bijoux' => $bijoux,
            'medias' => $medias,
            'chaussures' => $chaussures,
            'categories' => $categories,
            'souscategories' => $souscategories,
            'accessoires' => $accessoires,
        ]);
    }
}
