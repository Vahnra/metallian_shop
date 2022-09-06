<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Service\AccessoiresService;
use App\Service\MediaService;
use App\Service\BijouxService;
use App\Service\ChaussuresService;
use App\Service\VetementService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SousCategoryController extends AbstractController
{
    #[Route('/produits-{title1}/{title}', name: 'show_souscategorie_from_category', methods:['GET'])]
    public function showSousCategorie(
        SousCategorie $souscategories, 
        EntityManagerInterface $entityManager, 
        VetementService $vetementService, 
        BijouxService $bijouxService, 
        MediaService $mediaService,
        ChaussuresService $chaussuresService,
        AccessoiresService $accessoiresService,
        
        ): Response
    {
        // On utilise la fonction pour pagination
        $vetements = $vetementService->getPaginatedVetementsSousCategorie($souscategories);

        $bijoux = $bijouxService->getPaginatedBijouxSousCategorie($souscategories);

        $medias = $mediaService->getPaginatedMediasSousCategorie($souscategories);

        $chaussures = $chaussuresService->getPaginatedChaussuresSousCategorie($souscategories);

        $accessoires = $accessoiresService->getPaginatedAccessoiresSousCategorie($souscategories);

        // Conditions pour remplir les catégories
        if (!empty($bijoux[0])) {
            $categories = $entityManager->getRepository(Categorie::class)
                ->findBy([
                    'id' => $bijoux[0]->getCategorie()
            ]);
        } 
        
        if (!empty($vetements[0])) {
            $categories = $entityManager->getRepository(Categorie::class)
                ->findBy([
                    'id' => $vetements[0]->getCategorie()
            ]);
        }

        if (!empty($medias[0])) {
            $categories = $entityManager->getRepository(Categorie::class)
                ->findBy([
                    'id' => $medias[0]->getCategorie()
            ]);
        }

        if (!empty($chaussures[0])) {
            $categories = $entityManager->getRepository(Categorie::class)
                ->findBy([
                    'id' => $chaussures[0]->getCategorie()
            ]);
        }

        if (!empty($accessoires[0])) {
            $categories = $entityManager->getRepository(Categorie::class)
                ->findBy([
                    'id' => $accessoires[0]->getCategorie()
            ]);
        }
        
        $allsouscategories =$entityManager->getRepository(SousCategorie::class)->findAll();

        return $this->render("sous_category/show_souscategory_from_category.html.twig", [
            'categories' => $categories,
            'souscategories' => $souscategories,
            'allsouscategories' => $allsouscategories,
            'vetements' => $vetements,
            'bijoux' => $bijoux,
            'medias' => $medias,
            'chaussures' => $chaussures,
            'accessoires' => $accessoires,
            
        ]);
    }
}
