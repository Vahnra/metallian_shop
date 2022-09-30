<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Artist;
use App\Entity\Categorie;
use App\Entity\MusicType;
use App\Entity\Expedition;
use App\Entity\MediaQuantity;
use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirMediaController extends AbstractController
{
    #[Route('/voir/media-{id}', name: 'voir_media', methods:['GET', 'POST'])]
    public function voirMedia(Media $media ,EntityManagerInterface $entityManager): Response
    {
        $media = $entityManager->getRepository(Media::class)->findOneBy(['id'=>$media->getId()]);

        $mediaVariations = $entityManager->getRepository(MediaQuantity::class)->findBy(['media' => $media->getId()]);

        $artist = $entityManager->getRepository(Artist::class)->findBy(['id'=>$media->getArtist()]);
        
        $musicType = $entityManager->getRepository(MusicType::class)->findBy(['id'=>$media->getGenre()]);

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $similarCategory = $entityManager->getRepository(SousCategorie::class)->findBy([
            'id' => $media->getSousCategorie()  
        ]);

        $similarItm = $entityManager->getRepository(Media::class)->findBy([
            'sousCategorie' => $media->getSousCategorie()
           
        ]);
        $similaeGnr = $entityManager->getRepository(Media::class)->findBy([
            'genre' => $media->getGenre()
            
        ]);
    

        return $this->render('voir_media/voir_media.html.twig', [
            'media' => $media,
            'artist' => $artist,
            'musicType' => $musicType,
            'expedition' => $expedition,
            'similarItm' => $similarItm,
            'similaeGnr' => $similaeGnr,
        ]);
    }

       
        
   
}
