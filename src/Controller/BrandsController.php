<?php

namespace App\Controller;

use App\Entity\Marques;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandsController extends AbstractController
{
    #[Route('/brands', name: 'app_brands')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $brandsArticles = $entityManager->getRepository(Marques::class)->findAll();

        return $this->render('brands/index.html.twig', [
            'brandsArticles' => $brandsArticles
        ]);
    }
}
