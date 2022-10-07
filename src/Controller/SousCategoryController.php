<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Marques;
use App\Entity\Material;
use App\Entity\Categorie;
use App\Entity\MusicType;
use App\Entity\SousCategorie;
use App\Service\MediaService;
use App\Service\BijouxService;
use App\Service\VetementService;
use App\Form\MediaFilterFormType;
use App\Form\BijouxFilterFormType;
use App\Service\ChaussuresService;
use App\Service\AccessoiresService;
use App\Form\VetementFilterFormType;
use App\Form\ChaussuresFilterFormType;
use App\Form\AccessoiresFilterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SousCategoryController extends AbstractController
{
    #[Route('/articles-{title1}/{title}', name: 'show_souscategorie_from_category', methods: ['GET', 'POST'])]
    public function showSousCategorie(
        SousCategorie $souscategories,
        EntityManagerInterface $entityManager,
        VetementService $vetementService,
        BijouxService $bijouxService,
        MediaService $mediaService,
        ChaussuresService $chaussuresService,
        AccessoiresService $accessoiresService,
        Request $request
    ): Response 
    {
        $categories = $categories = $entityManager->getRepository(Categorie::class)
        ->findOneBy([
            'title' => $request->get("title1")
        ]);

        // Form pour le filtre
        $filterForm = $this->createForm(VetementFilterFormType::class)->handleRequest($request);

        // Form pour le filtre bijoux
        $filterBijouxForm = $this->createForm(BijouxFilterFormType::class)->handleRequest($request);

        // Form pour le filter chaussures
        $filterChaussuresForm = $this->createForm(ChaussuresFilterFormType::class)->handleRequest($request);

        // Form pour le filter accessoires
        $filterAccessoiresForm = $this->createForm(AccessoiresFilterFormType::class)->handleRequest($request);

        // Form pour le filter media
        $filterMediaForm = $this->createForm(MediaFilterFormType::class)->handleRequest($request);

        // Par défaut on utilise la fonction pour pagination
        $vetements = $vetementService->getPaginatedVetementsSousCategorie($souscategories);

        $bijoux = $bijouxService->getPaginatedBijouxSousCategorie($souscategories);

        $medias = $mediaService->getPaginatedMediasSousCategorie($souscategories);

        $chaussures = $chaussuresService->getPaginatedChaussuresSousCategorie($souscategories);

        $accessoires = $accessoiresService->getPaginatedAccessoiresSousCategorie($souscategories);

        // Si le formulair de filtre est soumit, il filtre
        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterForm->get('Couleur')->getData();

            $size = $filterForm->get('Size')->getData();

            $material = $filterForm->get('material')->getData();

            $marque = $filterForm->get('marque')->getData();

            $priceMini = $filterForm->get('priceMini')->getData();

            $priceMax = $filterForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $vetements = $vetementService->getPaginatedVetementsSousCategoriesFiltered(
                $souscategories, 
                $color, 
                $size, 
                $material, 
                $marque, 
                $priceMax, 
                $priceMini
            );        
        }

        if ($filterBijouxForm->isSubmitted() && $filterBijouxForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterBijouxForm->get('Couleur')->getData();

            $priceMini = $filterBijouxForm->get('priceMini')->getData();

            $priceMax = $filterBijouxForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $bijoux = $bijouxService->getPaginatedBijouxSousCategoriesFiltered(
                $souscategories, 
                $color, 
                $priceMax, 
                $priceMini
            );  
        }

        if ($filterAccessoiresForm->isSubmitted() && $filterAccessoiresForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterAccessoiresForm->get('Couleur')->getData();

            $material = $filterAccessoiresForm->get('material')->getData();

            $priceMini = $filterAccessoiresForm->get('priceMini')->getData();

            $priceMax = $filterAccessoiresForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $accessoires = $accessoiresService->getPaginatedAccessoiresSousCategoriesFiltered(
                $souscategories, 
                $color, 
                $material, 
                $priceMax, 
                $priceMini
            );        
        }

        if ($filterAccessoiresForm->isSubmitted() && $filterChaussuresForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterChaussuresForm->get('Couleur')->getData();

            $size = $filterChaussuresForm->get('Size')->getData();

            $material = $filterChaussuresForm->get('material')->getData();

            $priceMini = $filterChaussuresForm->get('priceMini')->getData();

            $priceMax = $filterChaussuresForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $chaussures = $chaussuresService->getPaginatedChaussuresSousCategoriesFiltered(
                $souscategories, 
                $color, 
                $size, 
                $material, 
                $priceMax, 
                $priceMini
            );        
        }

        if ($filterMediaForm->isSubmitted() && $filterMediaForm->isValid()) {
            // on prend les valeurs du formulaire
            $musicType = $filterMediaForm->get('musicType')->getData();

            $priceMini = $filterMediaForm->get('priceMini')->getData();

            $priceMax = $filterMediaForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $medias = $mediaService->getPaginatedMediaSousCategoriesFiltered(
                $souscategories, 
                $musicType,
                $priceMax, 
                $priceMini
            );        
        }

        $allsouscategories = $entityManager->getRepository(SousCategorie::class)->findAll();

        return $this->render("sous_category/show_souscategory_from_category.html.twig", [
            'categories' => $categories,
            'souscategories' => $souscategories,
            'allsouscategories' => $allsouscategories,
            'vetements' => $vetements,
            'bijoux' => $bijoux,
            'medias' => $medias,
            'chaussures' => $chaussures,
            'accessoires' => $accessoires,
            'filterForm' => $filterForm->createView(),
            'filterBijouxForm' => $filterBijouxForm->createView(),
            'filterChaussuresForm' => $filterChaussuresForm->createView(),
            'filterAccessoiresForm' => $filterAccessoiresForm->createView(),
            'filterMediaForm' => $filterMediaForm->createView(),
        ]);
    }
}
