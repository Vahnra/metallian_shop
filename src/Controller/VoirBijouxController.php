<?php

namespace App\Controller;

use App\Entity\Color;
use App\Entity\Bijoux;
use App\Entity\Expedition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirBijouxController extends AbstractController
{
    #[Route('/voir/bijoux-{id}', name: 'voir_bijoux', methods: ['GET'])]
    public function voirBijoux(Bijoux $bijoux ,EntityManagerInterface $entityManager): Response
    {
        $bijou = $entityManager->getRepository(Bijoux::class)->findBy(['id'=>$bijoux->getId()]);
        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$bijou[0]->getId()]);
        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        return $this->render('voir_bijoux/v_bijoux.html.twig', [
            'bijou' => $bijou,
            'color' => $color,
            'expedition' => $expedition
            
        ]);
    }
}
