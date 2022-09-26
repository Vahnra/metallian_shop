<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Material;
use App\Entity\Expedition;
use App\Entity\VetementMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirVetementMerchController extends AbstractController
{
    #[Route('/voir/vetement/merch-{id}', name: 'voir_vetement_merch', methods:['GET', 'POST'])]
    public function index(VetementMerchandising $vetementMerches, EntityManagerInterface $entityManager): Response
    {

        $vetementMerche = $entityManager->getRepository(VetementMerchandising::class)->findBy(['id'=>$vetementMerches->getId()]);

        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$vetementMerche[0]->getColor()]);

        $size = $entityManager->getRepository(Size::class)->findBy(['id'=>$vetementMerche[0]->getSize()]);
        
        $material = $entityManager->getRepository(Material::class)->findBy(['id'=>$vetementMerche[0]->getMaterial()]);

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $similarItm = $entityManager->getRepository(VetementMerchandising::class)->findBy([
            'sousCategorieMerchandising' => $vetementMerche[0]->getSousCategorieMerchandising(),
            'categorieMerchandising' => $vetementMerche[0]->getCategorieMerchandising(),
        ]);

        return $this->render('voir_vetement_merch/VoirVetementMerch.html.twig', [
            'vetementMerche' => $vetementMerche,
            'color' => $color,
            'size' => $size,
            'material' => $material,
            'expedition' => $expedition,
            'similarItm' => $similarItm,

        ]);
    }
}
