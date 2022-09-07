<?php

namespace App\Controller;

use App\Entity\Accessoires;
use App\Entity\Color;
use App\Entity\Material;
use App\Entity\Size;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoirAccessoiresController extends AbstractController
{
    #[Route('/voir/accessoires{id}', name: 'voir_accessoires', methods: ['GET'])]
    public function voirAccessoires(Accessoires $accessoires, Color $colors, Size $sizes, Material $materials, EntityManagerInterface $entityManager): Response
    {
        $accessoire = $entityManager->getRepository(Accessoires::class)->findBy(['id'=>$accessoires->getId()]);
        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$colors->getId()]);
        $size = $entityManager->getRepository(Size::class)->findBy(['id'=>$sizes->getId()]);
        $material = $entityManager->getRepository(Material::class)->findBy(['id'=>$materials->getId()]);
        return $this->render('voir_accessoires/voir_accessoires.html.twig', [
            'accessoire' => $accessoire,
            'color' => $color,
            'size' => $size,
            'material' => $material,
        ]);
    }
}
