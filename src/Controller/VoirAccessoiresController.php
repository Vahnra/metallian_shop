<?php

namespace App\Controller;

use App\Entity\Accessoires;
use App\Entity\Color;
use App\Entity\Expedition;
use App\Entity\Material;
use App\Entity\Size;
use App\Repository\ExpeditionRepository;
use App\Repository\VetementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoirAccessoiresController extends AbstractController
{
    #[Route('/voir/accessoires-{id}', name: 'voir_accessoires', methods: ['GET', 'POST'])]
    public function voirAccessoires(Accessoires $accessoires, EntityManagerInterface $entityManager): Response
    {
        $accessoire = $entityManager->getRepository(Accessoires::class)->findBy(['id'=>$accessoires->getId()]);
        
        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$accessoire[0]->getColor()]);

        $size = $entityManager->getRepository(Size::class)->findBy(['id'=>$accessoire[0]->getId()]);
      
        $material = $entityManager->getRepository(Material::class)->findBy(['id'=>$accessoire[0]->getId()]);

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        return $this->render('voir_accessoires/voir_accessoires.html.twig', [
            'accessoire' => $accessoire,
            'color' => $color,
            'size' => $size,
            'material' => $material,
        ]);
    }
}
