<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Vetement;
use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SousCategoryController extends AbstractController
{
    #[Route('/vetements-{title1}/{title}', name: 'show_souscategorie_from_category', methods:['GET'])]
    public function showSousCategorie(SousCategorie $souscategories, EntityManagerInterface $entityManager): Response
    {
        $vetements = $entityManager->getRepository(Vetement::class)
        ->findBy([
            'sousCategorie' => $souscategories->getId()
        ]);

        $categories = $entityManager->getRepository(Categorie::class)
        ->findBy([
            'id' => $vetements[0]->getCategorie()
        ]);

        $allsouscategories =$entityManager->getRepository(SousCategorie::class)->findAll();

        return $this->render("sous_category/show_souscategory_from_category.html.twig", [
            'souscategories' => $souscategories,
            'allsouscategories' => $allsouscategories,
            'vetements' => $vetements,
            'categories' => $categories,
        ]);
    }
}
