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
use App\Form\FilterFormType;
use App\Form\AllFilterFormType;
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
    #[Route('/nouveautes', name: 'new_products', methods: ['GET', 'POST'])]
    public function index(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        Request $request,
        PaginatorInterface $paginator,
    ): Response {
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        $categoriesMerchandising = $entityManager->getRepository(CategorieMerchandising::class)->findAll();

        $newVetements = $entityManager->getRepository(Vetement::class)->newProducts();
        $newVetementsMerchandising = $entityManager->getRepository(VetementMerchandising::class)->newProducts();
        $newMedias = $entityManager->getRepository(Media::class)->newProducts();
        $newChaussures = $entityManager->getRepository(Chaussures::class)->newProducts();
        $newBijoux = $entityManager->getRepository(Bijoux::class)->newProducts();
        $newAccessoires = $entityManager->getRepository(Accessoires::class)->newProducts();
        $newAccessoiresMerchandising = $entityManager->getRepository(AccessoiresMerchandising::class)->newProducts();

        $filterForm = $this->createForm(AllFilterFormType::class)->handleRequest($request);

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
                $priceMini,
                $priceMax
            );

            $newVetementsMerchandising = $entityManager->getRepository(VetementMerchandising::class)->findForPaginationFilteredNewProducts(
                $color,
                $size,
                $material,
                $marque,
                $priceMini,
                $priceMax
            );

            $newMedias = $entityManager->getRepository(Media::class)->findForPaginationFilteredNewProducts(
                $musicType,
                $priceMini,
                $priceMax
            );

            $newChaussures = $entityManager->getRepository(Chaussures::class)->findForPaginationFilteredNewProducts(
                $color,
                $size,
                $material,
                $marque,
                $priceMini,
                $priceMax
            );

            $newBijoux = $entityManager->getRepository(Bijoux::class)->findForPaginationFilteredNewProducts(
                $color,
                $priceMini,
                $priceMax
            );

            $newAccessoires = $entityManager->getRepository(Accessoires::class)->findForPaginationFilteredNewProducts(
                $color,
                $material,
                $priceMini,
                $priceMax
            );

            $newAccessoiresMerchandising = $entityManager->getRepository(AccessoiresMerchandising::class)->findForPaginationFilteredNewProducts(
                $color,
                $material,
                $priceMini,
                $priceMax
            );
        }

        $newProducts = array_merge($newVetements, $newVetementsMerchandising, $newMedias, $newChaussures, $newBijoux, $newAccessoires, $newAccessoiresMerchandising);

        $requestStack = $requestStack->getMainRequest();

        $page = $requestStack->query->getInt('page', 1);

        $searchResults = $paginator->paginate($newProducts, $page, 50, array('defaultSortFieldName' => 'a.createdAt', 'defaultSortDirection' => 'desc'));

        return $this->render('new_products/new_products.html.twig', [
            'newProducts' => $searchResults,
            'categories' => $categories,
            'categoriesMerchandising' => $categoriesMerchandising,
            'filterForm' => $filterForm->createView()
        ]);
    }
}
