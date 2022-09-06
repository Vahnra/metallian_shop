<?php

namespace App\Controller;

use App\Entity\Bijoux;
use App\Entity\Color;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoirBijouxController extends AbstractController
{
    #[Route('/voir/bijoux-{id}', name: 'voir_bijoux', methods: ['GET'])]
    public function voirBijoux(Bijoux $bijoux, Color $colors ,EntityManagerInterface $entityManager): Response
    {
        $bijou = $entityManager->getRepository(Bijoux::class)->findBy(['id'=>$bijoux->getId()]);
        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$colors->getId()]);
        return $this->render('voir_bijoux/v_bijoux.html.twig', [
            'bijou' => $bijou,
            'color' => $color,
            
        ]);
    }
}
