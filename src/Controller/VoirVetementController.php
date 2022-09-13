<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Material;
use App\Entity\Vetement;
use App\Entity\Expedition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirVetementController extends AbstractController
{
    #[Route('/voir/vetement-{id}', name: 'voir_vetement', methods:['GET', 'POST'])]
    public function voirVetement(Vetement $vetements, EntityManagerInterface $entityManager): Response
    {
        $vetement = $entityManager->getRepository(Vetement::class)->findBy(['id'=>$vetements->getId()]);

        $color = $entityManager->getRepository(Color::class)->findBy(['id'=>$vetement[0]->getColor()]);

        $size = $entityManager->getRepository(Size::class)->findBy(['id'=>$vetement[0]->getSize()]);
        
        $material = $entityManager->getRepository(Material::class)->findBy(['id'=>$vetement[0]->getMaterial()]);

        $expedition = $entityManager->getRepository(Expedition::class)->findAll();

        $similarItm = $entityManager->getRepository(Vetement::class)->findBy([
            'sousCategorie' => $vetement[0]->getSousCategorie(),
            'categorie' => $vetement[0]->getCategorie(),
        ]);

        return $this->render('voir_vetement/voir_vetement.html.twig', [
            'vetement' => $vetement,
            'color' => $color,
            'size' => $size,
            'material' => $material,
            'expedition' => $expedition,
            'similarItm' => $similarItm

        ]);
    }
}
