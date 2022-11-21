<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Marques;
use App\Entity\Material;
use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\Products;
use App\Service\VetementService;
use App\Entity\VetementMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BrandsController extends AbstractController
{
    #[Route('/marques', name: 'show_brands', methods:['GET', 'POST'])]
    public function showBrands(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        PaginatorInterface $paginator,
        Request $request
        ): Response
    {
        $brandsArticles = $entityManager->getRepository(Marques::class)->findAll();

        $products = $entityManager->getRepository(Products::class)->brandsProducts();

        // On récupère les info a mettre dans le filtre form
        $marques = $entityManager->getRepository(Marques::class)->findAll();

        $colors = $entityManager->getRepository(Color::class)->findAll();

        $materials = $entityManager->getRepository(Material::class)->findAll();

        $sizes = $entityManager->getRepository(Size::class)->findAll();

        $filterForm = $this->createFormBuilder()
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
                    'class' => 'no-border-radius'
                ],
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
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius'
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
                    'class' => 'no-border-radius'
                ],
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
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
                'required' => false,
            ])
            ->add('priceMax', MoneyType::class, [
                'label' => 'Prix max',
                'divisor' => 100,
                'required' => false,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
            ])
            ->add('priceMini', MoneyType::class, [
                'label' => 'Prix mini',
                'divisor' => 100,
                'required' => false,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
            ])
            ->add('Filtrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-dark btn-rounded waves-effect no-border-radius'
                ]
            ])
            ->getForm();

        $filterForm -> handleRequest($request);

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
            $products = $entityManager->getRepository(Products::class)->findForPaginationFilteredBrands(
                $color, 
                $size, 
                $material, 
                $marque, 
                $priceMini, 
                $priceMax
            );    
     
        }

        $requestStack = $requestStack->getMainRequest();   

        $page = $requestStack->query->getInt('page', 1);

        $allArticles = $paginator->paginate($products, $page, 5, array('defaultSortFieldName' => 'a.createdAt', 'defaultSortDirection' => 'desc'));

        return $this->render('brands/show_brands.html.twig', [
            'brandsArticles' => $brandsArticles,
            'allArticles' => $allArticles,
            'filterForm' => $filterForm->createView()
        ]);
    }

    #[Route('/marques/{id}', name: 'show_specific_brands', methods:['GET', 'POST'])]
    public function showSpecificBreand(
        Marques $brand,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        Request $request,
        PaginatorInterface $paginator
        ): Response
    {
        $brandsArticles = $entityManager->getRepository(Marques::class)->findAll();

        $brandProducts = $entityManager->getRepository(Products::class)->specificBrandsProducts($brand);

        // On récupère les info a mettre dans le filtre form
        $marques = $entityManager->getRepository(Marques::class)->findAll();

        $colors = $entityManager->getRepository(Color::class)->findAll();

        $materials = $entityManager->getRepository(Material::class)->findAll();

        $sizes = $entityManager->getRepository(Size::class)->findAll();

        $filterForm = $this->createFormBuilder()
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
                    'class' => 'no-border-radius'
                ],
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
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius'
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
                    'class' => 'no-border-radius'
                ],
                'required' => false,
            ])
            ->add('priceMax', MoneyType::class, [
                'label' => 'Prix max',
                'divisor' => 100,
                'required' => false,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
            ])
            ->add('priceMini', MoneyType::class, [
                'label' => 'Prix mini',
                'divisor' => 100,
                'required' => false,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
            ])
            ->add('Filtrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-dark btn-rounded waves-effect no-border-radius'
                ]
            ])
            ->getForm();

        $filterForm -> handleRequest($request);

        // Si le formulair de filtre est soumit, il filtre
        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            // on prend les valeurs du formulaire
            $color = $filterForm->get('Couleur')->getData();

            $size = $filterForm->get('Size')->getData();

            $material = $filterForm->get('material')->getData();

            $priceMini = $filterForm->get('priceMini')->getData();

            $priceMax = $filterForm->get('priceMax')->getData();

            // on insert et utilise le qb de filtre  
            $brandProducts = $entityManager->getRepository(Products::class)->findForPaginationFilteredSpecificBrands(
                $brand,
                $color, 
                $size, 
                $material,  
                $priceMini, 
                $priceMax
            );    
   
        }

        $requestStack = $requestStack->getMainRequest();   

        $page = $requestStack->query->getInt('page', 1);

        $allArticles = $paginator->paginate($brandProducts, $page, 5, array('defaultSortFieldName' => 'a.createdAt', 'defaultSortDirection' => 'desc'));

        return $this->render('brands/show_specific_brands.html.twig', [
            'brandsArticles' => $brandsArticles,
            'allArticles' => $allArticles,
            'brand' => $brand,
            'filterForm' => $filterForm->createView()
        ]);
    }
}
