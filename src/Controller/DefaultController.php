<?php

namespace App\Controller;

use App\Entity\Slider;
use App\Entity\Products;
use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\CategorieMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home', methods:['GET', 'POST'])]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $femme = $entityManager->getRepository(CategorieMerchandising::class)->findBy([
            'title' => 'Merchandising Femme'
        ]);

        $homme = $entityManager->getRepository(CategorieMerchandising::class)->findBy([
            'title' => 'Merchandising Homme'
        ]);

        $nouveautesFemme = $entityManager->getRepository(Products::class)->findByTwelveVetements($femme);

        $nouveautesHomme = $entityManager->getRepository(Products::class)->findByTwelveVetements($homme);

        $slider = $entityManager->getRepository(Slider::class)->findAll();

        return $this->render('default/home.html.twig', [
            'nouveautesFemme' => $nouveautesFemme,
            'nouveautesHomme' => $nouveautesHomme,
            'slider' => $slider,
        ]);
    }
}
