<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Bijoux;
use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\Chaussures;
use App\Entity\Accessoires;
use App\Entity\SousCategorie;
use App\Form\AllFilterFormType;
use App\Repository\MediaRepository;
use App\Repository\BijouxRepository;
use App\Entity\VetementMerchandising;
use App\Entity\CategorieMerchandising;
use App\Repository\VetementRepository;
use App\Entity\AccessoiresMerchandising;
use App\Repository\ChaussuresRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AccessoiresRepository;
use App\Entity\SousCategorieMerchandising;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\VetementMerchandisingRepository;
use App\Repository\AccessoiresMerchandisingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RenderController extends AbstractController
{
    #[Route('/categories1', name: 'render_categories_in_nav')]
    public function renderCategoriesInNav(EntityManagerInterface $entityManager): Response
    {
        // On récupère toutes les categories et sous categories normaux
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        $sousCategoriesGauche = $entityManager->getRepository(SousCategorie::class)->findBy(['position' => 'left']);

        $sousCategoriesDroite = $entityManager->getRepository(SousCategorie::class)->findBy(['position' => 'right']);

        return $this->render('rendered/categories_in_nav.html.twig', [
            'categories' => $categories,
            'sousCategoriesGauche' => $sousCategoriesGauche,
            'sousCategoriesDroite' => $sousCategoriesDroite,
        ]);
    }

    #[Route('/categories2', name: 'render_categories_merchandising_in_nav')]
    public function renderCategoriesMerchandisingInNav(EntityManagerInterface $entityManager): Response
    {
        // On récupre toutes les categoriesMerchandising et sousCategoriesMerchandising
        $categoriesMerchandising = $entityManager->getRepository(CategorieMerchandising::class)->findAll();

        $sousCategoriesMerchandisingGauche = $entityManager->getRepository(SousCategorieMerchandising::class)->findBy(['position' => 'left']);
        $sousCategoriesMerchandisingDroite = $entityManager->getRepository(SousCategorieMerchandising::class)->findBy(['position' => 'right']);

        return $this->render('rendered/categories_merchandising_in_nav.html.twig', [
            'categoriesMerchandising' => $categoriesMerchandising,
            'sousCategoriesMerchandisingGauche' => $sousCategoriesMerchandisingGauche,
            'sousCategoriesMerchandisingDroite' => $sousCategoriesMerchandisingDroite,
        ]);
    }

    #[Route('/categories3', name: 'render_categories_in_footer')]
    public function renderCategoriesInFooter(EntityManagerInterface $entityManager): Response
    {
        // On récupre toutes les categoriesMerchandising et catégories
        $categories = $entityManager->getRepository(Categorie::class)->findAll();
        $categoriesMerchandising = $entityManager->getRepository(CategorieMerchandising::class)->findAll();


        return $this->render('rendered/categories_in_footer.html.twig', [
            'categoriesMerchandising' => $categoriesMerchandising,
            'categories' => $categories

        ]);
    }

    #[Route('/search', name: 'render_search_article', methods:['GET', 'POST'])]
    public function renderSearchArticle(
        VetementRepository $vetementRepository, 
        ChaussuresRepository $chaussuresRepository, 
        MediaRepository $mediaRepository,
        AccessoiresRepository $accessoiresRepository,
        BijouxRepository $bijouxRepository,
        VetementMerchandisingRepository $vetementMerchandisingRepository,
        AccessoiresMerchandisingRepository $accessoiresMerchandisingRepository,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        PaginatorInterface $paginator,
        Request $request)
    {

        // On query toutes les catégories pour la side bar
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        $categoriesMerchandising = $entityManager->getRepository(CategorieMerchandising::class)->findAll();

        // query de filtre pour chaque tables
        $search = $request->get('search');

        $vetements = $vetementRepository->search($search);

        $chaussures = $chaussuresRepository->search($search);

        $medias = $mediaRepository->search($search);

        $accessoires = $accessoiresRepository->search($search);

        $bijoux = $bijouxRepository->search($search);

        $vetementMerchandising = $vetementMerchandisingRepository->search($search);

        $accessoiresMerchandising = $accessoiresMerchandisingRepository->search($search);

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
            $vetements = $entityManager->getRepository(Vetement::class)->searchFilter(
                $search,
                $color,
                $size,
                $material,
                $marque,
                $priceMini,
                $priceMax
            );

            $vetementMerchandising = $entityManager->getRepository(VetementMerchandising::class)->searchFilter(
                $search,
                $color,
                $size,
                $material,
                $marque,
                $priceMini,
                $priceMax
            );

            $medias = $entityManager->getRepository(Media::class)->searchFilter(
                $search,
                $musicType,
                $priceMini,
                $priceMax
            );

            $chaussures = $entityManager->getRepository(Chaussures::class)->searchFilter(
                $search,
                $color,
                $size,
                $material,
                $marque,
                $priceMini,
                $priceMax
            );

            $bijoux = $entityManager->getRepository(Bijoux::class)->searchFilter(
                $search,
                $color,
                $priceMini,
                $priceMax
            );

            $accessoires = $entityManager->getRepository(Accessoires::class)->searchFilter(
                $search,
                $color,
                $material,
                $priceMini,
                $priceMax
            );

            $accessoiresMerchandising = $entityManager->getRepository(AccessoiresMerchandising::class)->searchFilter(
                $search,
                $color,
                $material,
                $priceMini,
                $priceMax
            );
        }

        // On merge les resultats dans un meme tableau
        $searchResult = array_merge($chaussures, $vetements, $medias, $accessoires, $bijoux, $vetementMerchandising, $accessoiresMerchandising);

        // Partie pour la pagination 
        $requestStack = $requestStack->getMainRequest();   

        $page = $requestStack->query->getInt('page', 1);

        $searchResults = $paginator->paginate($searchResult, $page, 5, array('defaultSortFieldName' => 'a.createdAt', 'defaultSortDirection' => 'desc'));

        return $this->render('search_result/search_result.html.twig', [
            'searchResults' => $searchResults,
            'search' => $search,
            'categories' => $categories,
            'categoriesMerchandising' => $categoriesMerchandising,
            'filterForm' => $filterForm->createView()
        ]);
    }
    
}
