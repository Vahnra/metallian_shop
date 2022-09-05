<?php

namespace App\Controller;

use App\Entity\Accessoires;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoirAccessoiresController extends AbstractController
{
    #[Route('/voir/accessoires{id}', name: 'voir_accessoires', methods: ['GET'])]
    public function voirAccessoires(Accessoires $accessoires, EntityManagerInterface $entityManager): Response
    {
        $accessoire = $entityManager->getRepository(Accessoires::class)->findBy(['id'=>$accessoires->getId()]);
        return $this->render('voir_accessoires/voir_accessoires.html.twig', [
            'accessoire' => $accessoire,
        ]);
    }
}
