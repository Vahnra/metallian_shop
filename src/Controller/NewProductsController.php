<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Media;
use App\Entity\Bijoux;
use App\Entity\Marques;
use App\Entity\Material;
use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\MusicType;
use App\Entity\Chaussures;
use App\Entity\Accessoires;
use App\Entity\VetementMerchandising;
use App\Entity\CategorieMerchandising;
use App\Entity\AccessoiresMerchandising;
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

class NewProductsController extends AbstractController
{
    #[Route('/nouveautes', name: 'new_products', methods:['GET', 'POST'])]
    public function index(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        Request $request,
        PaginatorInterface $paginator,
    ): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        $categoriesMerchandising = $entityManager->getRepository(CategorieMerchandising::class)->findAll();

        $newVetements = $entityManager->getRepository(Vetement::class)->newProducts();
        $newVetementsMerchandising = $entityManager->getRepository(VetementMerchandising::class)->newProducts();
        $newMedias = $entityManager->getRepository(Media::class)->newProducts();
        $newChaussures = $entityManager->getRepository(Chaussures::class)->newProducts();
        $newBijoux = $entityManager->getRepository(Bijoux::class)->newProducts();
        $newAccessoires = $entityManager->getRepository(Accessoires::class)->newProducts();
        $newAccessoiresMerchandising = $entityManager->getRepository(AccessoiresMerchandising::class)->newProducts();

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
                'attr' => [
                    'class' => 'no-border-radius'
                ],
                'required' => false,
            ])
            ->add('musicType', ChoiceType::class, [
                'label' => 'Genre musical',
                'placeholder' => 'Choisir un genre',
                'choices' => $musicType,
                'choice_value' => 'id',
                'choice_label' => function(?MusicType $category) {
                    return $category ? $category->getGenre() : '';
                },
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

            $musicType = $filterForm->get('musicType')->getData();

            $priceMini = $filterForm->get('priceMini')->getData();

            $priceMax = $filterForm->get('priceMax')->getData();
    
            // On fait appelle au qb par les repo
            $newVetements = $entityManager->getRepository(Vetement::class)->findForPaginationFilteredNewProducts(
                $color, 
                $size, 
                $material, 
                $marque, 
                $priceMax, 
                $priceMini
            );        
        }

        $newProducts = array_merge($newVetements, $newVetementsMerchandising, $newMedias, $newChaussures, $newBijoux, $newAccessoires, $newAccessoiresMerchandising);

        $requestStack = $requestStack->getMainRequest();   

        $page = $requestStack->query->getInt('page', 1);

        $searchResults = $paginator->paginate($newProducts, $page, 5, array('defaultSortFieldName' => 'a.createdAt', 'defaultSortDirection' => 'desc'));

        return $this->render('new_products/new_products.html.twig', [
            'newProducts' => $searchResults,
            'categories' => $categories,
            'categoriesMerchandising' => $categoriesMerchandising,
            'filterForm' => $filterForm->createView()
        ]);
    }

}
