<?php

namespace App\Controller;

use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoirMediaController extends AbstractController
{
    #[Route('/voir/media-{id}', name: 'voir_media', methods:['GET', 'POST'])]
    public function index(Media $media ,EntityManagerInterface $entityManager): Response
    {
        $medium = $entityManager->getRepository(Media::class)->findBy(['id'=>$media->getId()]);
        return $this->render('voir_media/voir_media.html.twig', [
            'medium' => $medium,
        ]);
    }
}
