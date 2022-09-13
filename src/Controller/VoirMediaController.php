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
    #[Route('/voir/media-{id}', name: 'voir_media', methods:['GET', 'POST'])]
    public function index(Media $media ,EntityManagerInterface $entityManager): Response
    {
        $medium = $entityManager->getRepository(Media::class)->findBy(['id'=>$media->getId()]);

        $artist = $entityManager->getRepository(Artist::class)->findBy(['id'=>$medium[0]->getArtist()]);
        
        $musicType = $entityManager->getRepository(MusicType::class)->findBy(['id'=>$medium[0]->getGenre()]);

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $similarCategory = $entityManager->getRepository(SousCategorie::class)->findBy([
            'id' => $medium[0]->getSousCategorie()  
        ]);

        $similarItm = $entityManager->getRepository(Media::class)->findBy([
            'sousCategorie' => $medium[0]->getSousCategorie(),
            // 'artist'=>$medium[0]->getArtist()
        ]);
        $similaeGnr = $entityManager->getRepository(Media::class)->findBy([
            'genre' => $medium[0]->getGenre(),
            // 'artist'=>$medium[0]->getArtist()
        ]);
    // dd($medium[0]->getArtist());

        return $this->render('voir_media/voir_media.html.twig', [
            'medium' => $medium,
            'artist' => $artist,
            'musicType' => $musicType,
            'expedition' => $expedition,
            'similarItm' => $similarItm,
            'similaeGnr' => $similaeGnr,
        ]);
    }

       
        
   
}
