<?php

namespace App\Controller;

use App\Entity\Slider;
use App\Entity\Products;
use App\Entity\Vetement;
use App\Entity\Categorie;
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
        $femme = $entityManager->getRepository(Categorie::class)->findBy([
            'title' => 'Femme'
        ]);
    $test = json_decode($request->getContent(), true);
        return $this->redirectToRoute('default_home');

        $homme = $entityManager->getRepository(Categorie::class)->findBy([
            'title' => 'Homme'
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
