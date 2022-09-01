<?php

namespace App\Controller;

use App\Entity\Vetement;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home', methods:['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $femme = $entityManager->getRepository(Categorie::class)->findBy([
            'title' => 'Femme'
        ]);

        $homme = $entityManager->getRepository(Categorie::class)->findBy([
            'title' => 'Homme'
        ]);

        $nouveautesFemme = $entityManager->getRepository(Vetement::class)->findByFourVetements($femme);

        $nouveautesHomme = $entityManager->getRepository(Vetement::class)->findByFourVetements($homme);

        return $this->render('default/home.html.twig', [
            'nouveautesFemme' => $nouveautesFemme,
            'nouveautesHomme' => $nouveautesHomme,
        ]);
    }
}
