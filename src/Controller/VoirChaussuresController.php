<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Chaussures;
use App\Entity\Expedition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirChaussuresController extends AbstractController
{
    #[Route('/voir/chaussures-{id}', name: 'voir_chaussures', methods: ['GET', 'POST'])]
    public function index(Chaussures $chaussures, EntityManagerInterface $entityManager): Response
    {
        $chaussure = $entityManager->getRepository(Chaussures::class)->findBy(['id'=>$chaussures->getId()]);

        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$chaussure[0]->getColor()]);

        $size = $entityManager->getRepository(Size::class)->findBy(['id'=>$chaussure[0]->getId()]);
      
        $expedition = $entityManager->getRepository(Expedition::class)->findAll();
    
        return $this->render('voir_chaussures/voir_chaussures.html.twig', [
            'chaussure' => $chaussure,
            'color' => $color,
            'size' => $size,
            'expedition' => $expedition

        ]);
    }
}
