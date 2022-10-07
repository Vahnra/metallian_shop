<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Marques;
use App\Entity\Material;
use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\MusicType;
use App\Entity\SousCategorie;
use App\Service\MediaService;
use App\Service\BijouxService;
use App\Service\VetementService;
use App\Form\BijouxFilterFormType;
use App\Service\ChaussuresService;
use App\Service\AccessoiresService;
use App\Form\VetementFilterFormType;
use App\Form\ChaussuresFilterFormType;
use App\Repository\VetementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/articles-{title}', name: 'show_vetements_from_category', methods:['GET', 'POST'])]
    public function showVetementsFromCategorie(
        Categorie $categories, 
        EntityManagerInterface $entityManager, 
        VetementService $vetementService, 
        BijouxService $bijouxService, 
        MediaService $mediaService,
        ChaussuresService $chaussuresService,
        AccessoiresService $accessoiresService,
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
        $filterForm = $this->createForm(VetementFilterFormType::class)->handleRequest($request);

        // Form pour le filtre bijoux
        $filterBijouxForm = $this->createForm(BijouxFilterFormType::class)->handleRequest($request);

        // Form pour le filter chaussures
        $filterChaussuresForm = $this->createForm(ChaussuresFilterFormType::class)->handleRequest($request);

        // Form pour le filter accessoires
        $filterAccessoiresForm = $this->createFormBuilder()
            ->add('Couleur', ChoiceType::class, [
                'placeholder' => 'Choisir une couleur',
                'choices' => $colors,
                'choice_value' => 'id',
                'choice_label' => function(?Color $category) {
                    return $category ? $category->getColor() : '';
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius col-12',
                    'style' => 'display: none;'
                ],
                'label_attr' => [
                    'id' => 'color',
                    'class' => 'col-10',
                    'onclick' => 'showColorFilter()',
                    'style' => 'cursor: pointer;'
                ],
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
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius col-12',
                    'style' => 'display: none;'
                ],
                'label_attr' => [
                    'id' => 'material',
                    'class' => 'col-10',
                    'onclick' => 'showMaterialFilter()',
                    'style' => 'cursor: pointer;'
                ],
                'required' => false,
            ])
            ->add('priceMax', MoneyType::class, [
                'label' => 'Prix max',
                'divisor' => 100,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
                'required' => false,
            ])
            ->add('priceMini', MoneyType::class, [
                'label' => 'Prix mini',
                'divisor' => 100,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
                'required' => false,
            ])
            ->add('Filtrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-dark btn-rounded waves-effect no-border-radius'
                ]
            ])
            ->getForm();

        $filterAccessoiresForm -> handleRequest($request);

        // Form pour le filter media
        $filterMediaForm = $this->createFormBuilder()
            ->add('musicType', ChoiceType::class, [
                'label' => 'Genre musical',
                'placeholder' => 'Choisir un genre',
                'choices' => $musicType,
                'choice_value' => 'id',
                'choice_label' => function(?MusicType $category) {
                    return $category ? $category->getGenre() : '';
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius col-12',
                    'style' => 'display: none;'
                ],
                'label_attr' => [
                    'id' => 'musicType',
                    'class' => 'col-10',
                    'onclick' => 'showMusicTypeFilter()',
                    'style' => 'cursor: pointer;'
                ],
                'required' => false,
            ])
            ->add('priceMax', MoneyType::class, [
                'label' => 'Prix max',
                'divisor' => 100,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
                'required' => false,
            ])
            ->add('priceMini', MoneyType::class, [
                'label' => 'Prix mini',
                'divisor' => 100,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
                'required' => false,
            ])
            ->add('Filtrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-dark btn-rounded waves-effect no-border-radius'
                ]
            ])
            ->getForm();

        $filterMediaForm -> handleRequest($request);

        // Par défaut la pagination renvoit tout
        $vetements = $vetementService->getPaginatedVetements($categories);

        $bijoux = $bijouxService->getPaginatedBijoux($categories);

        $medias = $mediaService->getPaginatedMedias($categories);

        $chaussures = $chaussuresService->getPaginatedChaussures($categories);

        $accessoires = $accessoiresService->getPaginatedAccessoires($categories);

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
    
            $vetements = $vetementService->getPaginatedVetementsFilteredByColor(
                $categories, 
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
    
            $bijoux = $bijouxService->getPaginatedBijouxFiltered(
                $categories, 
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
    
            $accessoires = $accessoiresService->getPaginatedAccessoiresFiltered(
                $categories, 
                $color, 
                $material, 
                $priceMax, 
                $priceMini
            );        
        }  

        if ($filterChaussuresForm->isSubmitted() && $filterChaussuresForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterChaussuresForm->get('Couleur')->getData();

            $size = $filterChaussuresForm->get('Size')->getData();

            $material = $filterChaussuresForm->get('material')->getData();

            $priceMini = $filterChaussuresForm->get('priceMini')->getData();

            $priceMax = $filterChaussuresForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre
    
            $chaussures = $chaussuresService->getPaginatedChaussuresFiltered(
                $categories, 
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
    
            $medias = $mediaService->getPaginatedMediaFiltered(
                $categories, 
                $musicType,
                $priceMax, 
                $priceMini
            );        
        }  

        // On récupère les sous catégories de la catégories en question
        $souscategories = $entityManager->getRepository(SousCategorie::class)->findAll();

        return $this->render("category/show_vetements_from_category.html.twig", [
            'vetements' => $vetements,
            'bijoux' => $bijoux,
            'medias' => $medias,
            'chaussures' => $chaussures,
            'categories' => $categories,
            'souscategories' => $souscategories,
            'accessoires' => $accessoires,
            'filterForm' => $filterForm->createView(),
            'filterBijouxForm' => $filterBijouxForm->createView(),
            'filterChaussuresForm' => $filterChaussuresForm->createView(),
            'filterAccessoiresForm' => $filterAccessoiresForm->createView(),
            'filterMediaForm' => $filterMediaForm->createView(),
        ]);
    }
}
