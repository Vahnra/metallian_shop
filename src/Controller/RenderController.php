<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Form\SearchArticleType;
use App\Repository\MediaRepository;
use App\Repository\BijouxRepository;
use App\Entity\CategorieMerchandising;
use App\Repository\VetementRepository;
use App\Repository\ChaussuresRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AccessoiresRepository;
use App\Entity\SousCategorieMerchandising;
use App\Repository\AccessoiresMerchandisingRepository;
use App\Repository\VetementMerchandisingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RenderController extends AbstractController
{
    #[Route('/categories1', name: 'render_categories_in_nav')]
    public function renderCategoriesInNav(EntityManagerInterface $entityManager): Response
    {
        // On récupère toutes les categories et sous categories normaux
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        $souscategories = $entityManager->getRepository(SousCategorie::class)->findAll();

        return $this->render('rendered/categories_in_nav.html.twig', [
            'categories' => $categories,
            'souscategories' => $souscategories
        ]);
    }

    #[Route('/categories2', name: 'render_categories_merchandising_in_nav')]
    public function renderCategoriesMerchandisingInNav(EntityManagerInterface $entityManager): Response
    {
        // On récupre toutes les categoriesMerchandising et sousCategoriesMerchandising
        $categoriesMerchandising = $entityManager->getRepository(CategorieMerchandising::class)->findAll();

        $souscategoriesMerchandising = $entityManager->getRepository(SousCategorieMerchandising::class)->findAll();

        return $this->render('rendered/categories_merchandising_in_nav.html.twig', [
            'categoriesMerchandising' => $categoriesMerchandising,
            'souscategoriesMerchandising' => $souscategoriesMerchandising
        ]);
    }

    #[Route('/search', name: 'render_search_article', methods:['GET'])]
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

        // query de filtre pour chaque tables
        $search = $request->get('search');

        $vetements = $vetementRepository->search($search);

        $chaussures = $chaussuresRepository->search($search);

        $medias = $mediaRepository->search($search);

        $accessoires = $accessoiresRepository->search($search);

        $bijoux = $bijouxRepository->search($search);

        $vetementMerchandising = $vetementMerchandisingRepository->search($search);

        $accessoiresMerchandising = $accessoiresMerchandisingRepository->search($search);

        // On merge les resultats dans un meme tableau
        $searchResult = array_merge($chaussures, $vetements, $medias, $accessoires, $bijoux, $vetementMerchandising, $accessoiresMerchandising);

        // Partie pour la pagination 
        $requestStack = $requestStack->getMainRequest();        

        $page = $requestStack->query->getInt('page', 1);

        $searchResults = $paginator->paginate($searchResult, $page, 5);

        return $this->render('search_result/index.html.twig', [
            'searchResults' => $searchResults,
            'search' => $search,
            'categories' => $categories
        ]);
    }
    
}
