<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Material;
use App\Entity\Expedition;
use Doctrine\ORM\EntityManager;
use App\Entity\AccessoiresMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirAccessoriesMerchController extends AbstractController
{
    #[Route('/voir/accessories/merch-{id}', name: 'voir_accessories_merch', methods:['GET', 'POST'])]
    public function index(AccessoiresMerchandising $accessoiresMerches, EntityManagerInterface $entityManager): Response
    {

        $accessoriesMerch = $entityManager->getRepository(AccessoiresMerchandising::class)->findBy(['id'=>$accessoiresMerches->getId()]);

        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$accessoriesMerch[0]->getColor()]);

        $size = $entityManager->getRepository(Size::class)->findBy(['id'=>$accessoriesMerch[0]->getSize()]);
        
        $material = $entityManager->getRepository(Material::class)->findBy(['id'=>$accessoriesMerch[0]->getMaterial()]);

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $similarItm = $entityManager->getRepository(AccessoiresMerchandising::class)->findBy([
            'sousCategorieMerchandising' => $accessoriesMerch[0]->getSousCategorieMerchandising(),
            'categorieMerchandising' => $accessoriesMerch[0]->getCategorieMerchandising(),
        ]);

        return $this->render('voir_accessories_merch/accessoriesMerch.html.twig', [
            'accessoriesMerch' => $accessoriesMerch,
            'color' => $color,
            'size' => $size,
            'material' => $material,
            'expedition' => $expedition,
            'similarItm' => $similarItm,
        ]);
    }
}
