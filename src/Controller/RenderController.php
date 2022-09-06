<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Form\SearchArticleType;
use App\Entity\CategorieMerchandising;
use App\Repository\VetementRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SousCategorieMerchandising;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

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

    #[Route('/search', name: 'render_search_article', methods:['GET', 'POST'])]
    public function renderSearchArticle(VetementRepository $vetementRepository, RequestStack $requestStack)
    {
        $request = $requestStack->getMainRequest() ?? $requestStack->getCurrentRequest();;

        $form = $this->createForm(SearchArticleType::class)->handleRequest($request);

        $articles = '';

        if ($form->isSubmitted() && $form->isValid()) {

            $annonces = $form->get('mots')->getData();

            $articles = $vetementRepository->search($annonces);

            return $this->redirectToRoute('search_result', [
                'articles' => $articles,
                'recherche' => $annonces
            ]);
        }

        return $this->render('rendered/search_article.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles
        ]);
    }

}
