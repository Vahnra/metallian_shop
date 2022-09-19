<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Marques;
use App\Entity\Material;
use App\Entity\MusicType;
use App\Entity\CategorieMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SousCategorieMerchandising;
use App\Service\AccessoiresMerchandisingService;
use App\Service\VetementMerchandisingService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MerchandisingController extends AbstractController
{
    #[Route('/merchandising-{title}', name: 'show_from_category_merchandising', methods:['GET', 'POST'])]
    public function showFromCategoryMerchandising(
        CategorieMerchandising $categorieMerchandising,
        VetementMerchandisingService $vetementMerchandisingService,
        AccessoiresMerchandisingService $accessoiresService,
        EntityManagerInterface $entityManager,
        Request $request
        ): Response
    {
        // On récupère les info a mettre dans le filtre form
        $marques = $entityManager->getRepository(Marques::class)->findAll();

        $colors = $entityManager->getRepository(Color::class)->findAll();

        $materials = $entityManager->getRepository(Material::class)->findAll();

        $sizes = $entityManager->getRepository(Size::class)->findAll();

        $musicType = $entityManager->getRepository(MusicType::class)->findAll();

        // Form pour le filtre
        $filterForm = $this->createFormBuilder()
            ->add('Couleur', ChoiceType::class, [
                'placeholder' => 'Choisir une couleur',
                'choices' => $colors,
                'choice_value' => 'id',
                'choice_label' => function(?Color $category) {
                    return $category ? $category->getColor() : '';
                },
                'required' => false,
            ])
            ->add('Size', ChoiceType::class, [
                'label' => 'Taille',
                'placeholder' => 'Choisir une taille',
                'choices'  => $sizes,
                'choice_value' => 'id',
                'choice_label' => function(?Size $category) {
                    return $category ? $category->getSize() : '';
                },
                'required' => false,
            ])
            ->add('material', ChoiceType::class, [
                'label' => 'Matière',
                'placeholder' => 'Choisir une matière',
                'choices'  => $materials,
                'choice_value' => 'id',
                'choice_label' => function(?Material $category) {
                    return $category ? $category->getMaterial() : '';
                },
                'required' => false,
            ])
            ->add('marque', ChoiceType::class, [
                'label' => 'Marques',
                'placeholder' => 'Choisir une marque',
                'choices'  => $marques,
                'choice_value' => 'id',
                'choice_label' => function(?Marques $category) {
                    return $category ? $category->getTitle() : '';
                },
                'required' => false,
            ])
            ->add('priceMax', MoneyType::class, [
                'label' => 'Prix max',
                'divisor' => 100,
                'required' => false,
            ])
            ->add('priceMini', MoneyType::class, [
                'label' => 'Prix mini',
                'divisor' => 100,
                'required' => false,
            ])
            ->add('Filtrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-dark btn-rounded waves-effect'
                ]
            ])
            ->getForm();

        $filterForm -> handleRequest($request);

        // Form pour le filter accessoires
        $filterAccessoiresForm = $this->createFormBuilder()
            ->add('Couleur', ChoiceType::class, [
                'placeholder' => 'Choisir une couleur',
                'choices' => $colors,
                'choice_value' => 'id',
                'choice_label' => function(?Color $category) {
                    return $category ? $category->getColor() : '';
                },
                'required' => false,
            ])
            ->add('material', ChoiceType::class, [
                'label' => 'Matière',
                'placeholder' => 'Choisir une matière',
                'choices'  => $materials,
                'choice_value' => 'id',
                'choice_label' => function(?Material $category) {
                    return $category ? $category->getMaterial() : '';
                },
                'required' => false,
            ])
            ->add('priceMax', MoneyType::class, [
                'label' => 'Prix max',
                'divisor' => 100,
                'required' => false,
            ])
            ->add('priceMini', MoneyType::class, [
                'label' => 'Prix mini',
                'divisor' => 100,
                'required' => false,
            ])
            ->add('Filtrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-dark btn-rounded waves-effect'
                ]
            ])
            ->getForm();

        $filterAccessoiresForm -> handleRequest($request);

        // Par défaut la pagination renvoit tout
        $vetements = $vetementMerchandisingService->getPaginatedVetements($categorieMerchandising);

        $accessoires = $accessoiresService->getPaginatedAccessoires($categorieMerchandising);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterForm->get('Couleur')->getData();

            $size = $filterForm->get('Size')->getData();

            $material = $filterForm->get('material')->getData();

            $marque = $filterForm->get('marque')->getData();

            $priceMini = $filterForm->get('priceMini')->getData();

            $priceMax = $filterForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $vetements = $vetementMerchandisingService->getPaginatedVetementsFiltered(
                $categorieMerchandising, 
                $color, 
                $size, 
                $material, 
                $marque, 
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
    
            $accessoires = $accessoiresService->getPaginatedAccessoiresFiltered(
                $categorieMerchandising, 
                $color, 
                $material, 
                $priceMax, 
                $priceMini
            );        
        }
        
        // On récupère les sous catégories de la catégories en question
        $souscategories = $entityManager->getRepository(SousCategorieMerchandising::class)->findAll();

        return $this->render('category/show_from_category_merchandising.html.twig', [
            'categories' => $categorieMerchandising,
            'souscategories' => $souscategories,
            'vetements' => $vetements,
            'accessoires' => $accessoires,
            'filterForm' => $filterForm->createView(),
            'filterAccessoiresForm' => $filterAccessoiresForm->createView(),
        ]);
    }

    #[Route('/merchand-{title1}/{title}', name:'show_merchandising_sous_categorie', methods:['GET', 'POST'])]
    public function showMerchandisingSousCategorie(
        SousCategorieMerchandising $souscategories,
        VetementMerchandisingService $vetementMerchandisingService,
        AccessoiresMerchandisingService $accessoiresService,
        EntityManagerInterface $entityManager,
        Request $request
        ): Response 
    {
        // On récupère les info a mettre dans le filtre form
        $marques = $entityManager->getRepository(Marques::class)->findAll();

        $colors = $entityManager->getRepository(Color::class)->findAll();

        $materials = $entityManager->getRepository(Material::class)->findAll();

        $sizes = $entityManager->getRepository(Size::class)->findAll();

        $musicType = $entityManager->getRepository(MusicType::class)->findAll();

        // Form pour le filtre
        $filterForm = $this->createFormBuilder()
            ->add('Couleur', ChoiceType::class, [
                'placeholder' => 'Choisir une couleur',
                'choices' => $colors,
                'choice_value' => 'id',
                'choice_label' => function(?Color $souscategories) {
                    return $souscategories ? $souscategories->getColor() : '';
                },
                'required' => false,
            ])
            ->add('Size', ChoiceType::class, [
                'label' => 'Taille',
                'placeholder' => 'Choisir une taille',
                'choices'  => $sizes,
                'choice_value' => 'id',
                'choice_label' => function(?Size $souscategories) {
                    return $souscategories ? $souscategories->getSize() : '';
                },
                'required' => false,
            ])
            ->add('material', ChoiceType::class, [
                'label' => 'Matière',
                'placeholder' => 'Choisir une matière',
                'choices'  => $materials,
                'choice_value' => 'id',
                'choice_label' => function(?Material $souscategories) {
                    return $souscategories ? $souscategories->getMaterial() : '';
                },
                'required' => false,
            ])
            ->add('marque', ChoiceType::class, [
                'label' => 'Marques',
                'placeholder' => 'Choisir une marque',
                'choices'  => $marques,
                'choice_value' => 'id',
                'choice_label' => function(?Marques $souscategories) {
                    return $souscategories ? $souscategories->getTitle() : '';
                },
                'required' => false,
            ])
            ->add('priceMax', MoneyType::class, [
                'label' => 'Prix max',
                'divisor' => 100,
                'required' => false,
            ])
            ->add('priceMini', MoneyType::class, [
                'label' => 'Prix mini',
                'divisor' => 100,
                'required' => false,
            ])
            ->add('Filtrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-dark btn-rounded waves-effect'
                ]
            ])
            ->getForm();

        $filterForm -> handleRequest($request);

        // Form pour le filter accessoires
        $filterAccessoiresForm = $this->createFormBuilder()
            ->add('Couleur', ChoiceType::class, [
                'placeholder' => 'Choisir une couleur',
                'choices' => $colors,
                'choice_value' => 'id',
                'choice_label' => function(?Color $souscategories) {
                    return $souscategories ? $souscategories->getColor() : '';
                },
                'required' => false,
            ])
            ->add('material', ChoiceType::class, [
                'label' => 'Matière',
                'placeholder' => 'Choisir une matière',
                'choices'  => $materials,
                'choice_value' => 'id',
                'choice_label' => function(?Material $souscategories) {
                    return $souscategories ? $souscategories->getMaterial() : '';
                },
                'required' => false,
            ])
            ->add('priceMax', MoneyType::class, [
                'label' => 'Prix max',
                'divisor' => 100,
                'required' => false,
            ])
            ->add('priceMini', MoneyType::class, [
                'label' => 'Prix mini',
                'divisor' => 100,
                'required' => false,
            ])
            ->add('Filtrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-dark btn-rounded waves-effect'
                ]
            ])
            ->getForm();

        $filterAccessoiresForm -> handleRequest($request);

        // Par défaut la pagination renvoit tout
        $vetements = $vetementMerchandisingService->getPaginatedVetementsSousCategorie($souscategories);

        $accessoires = $accessoiresService->getPaginatedAccessoiresSousCategorie($souscategories);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterForm->get('Couleur')->getData();

            $size = $filterForm->get('Size')->getData();

            $material = $filterForm->get('material')->getData();

            $marque = $filterForm->get('marque')->getData();

            $priceMini = $filterForm->get('priceMini')->getData();

            $priceMax = $filterForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $vetements = $vetementMerchandisingService->getPaginatedVetementsSousCategoriesFiltered(
                $souscategories, 
                $color, 
                $size, 
                $material, 
                $marque, 
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

        $categorieMerchandising = [];

        // Conditions pour remplir les catégories
        if (!empty($vetements[0])) {
            $categorieMerchandising = $entityManager->getRepository(CategorieMerchandising::class)
                ->findBy([
                    'id' => $vetements[0]->getCategorieMerchandising()
                ]);
        }

        if (!empty($accessoires[0])) {
            $categorieMerchandising = $entityManager->getRepository(CategorieMerchandising::class)
                ->findBy([
                    'id' => $accessoires[0]->getCategorieMerchandising()
                ]);
        }

        $allsouscategories = $entityManager->getRepository(SousCategorieMerchandising::class)->findAll();

        return $this->render("sous_category/show_merchandising_sous_category.html.twig", [
            'categories' => $categorieMerchandising,
            'souscategories' => $souscategories,
            'allsouscategories' => $allsouscategories,
            'vetements' => $vetements,
            'accessoires' => $accessoires,
            'filterForm' => $filterForm->createView(),
            'filterAccessoiresForm' => $filterAccessoiresForm->createView(),
        ]);
    }
}
