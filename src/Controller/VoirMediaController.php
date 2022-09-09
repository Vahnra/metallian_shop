<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Artist;
use App\Entity\Categorie;
use App\Entity\MusicType;
use App\Entity\Expedition;
use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirMediaController extends AbstractController
{
    #[Route('/voir/media-{id}', name: 'app_voir_media', methods:['GET', 'POST'])]
    public function index(Media $media ,EntityManagerInterface $entityManager): Response
    {
        $medium = $entityManager->getRepository(Media::class)->findBy(['id'=>$media->getId()]);

        $artist = $entityManager->getRepository(Artist::class)->findBy(['id'=>$medium[0]->getArtist()]);
        
        $musicType = $entityManager->getRepository(MusicType::class)->findBy(['id'=>$medium[0]->getGenre()]);

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();



        return $this->render('voir_media/voir_media.html.twig', [
            'medium' => $medium,
            'artist' => $artist,
            'musicType' => $musicType,
            'expedition' => $expedition
        ]);
    }

       
        
   
}
