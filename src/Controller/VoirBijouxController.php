<?php

namespace App\Controller;

use App\Entity\Bijoux;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoirBijouxController extends AbstractController
{
    #[Route('/voir/bijoux{id}', name: 'voir_bijoux', methods: ['GET'])]
    public function voirBijoux(Bijoux $bijoux ,EntityManagerInterface $entityManager): Response
    {
        $bijou = $entityManager->getRepository(Bijoux::class)->findBy(['id'=>$bijoux->getId()]);
        return $this->render('voir_bijoux/v_bijoux.html.twig', [
            'bijou' => $bijou,
            
        ]);
    }
}
