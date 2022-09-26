<?php

namespace App\Controller;

use DateTime;
use App\Entity\Bijoux;
use App\Entity\Vetement;
use App\Entity\FavoriteProduct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteProductController extends AbstractController
{
    #[Route('/favorite/product', name: 'show_favorite_products')]
    public function showFavoriteProducts(): Response
    {
        return $this->render('favorite_product/index.html.twig');
    }

    #[Route('/add-favorite/vetement-{id}', name: 'add_favorite_vetement', methods:['GET', 'POST'])]
    public function addFavoriteVetement(
        Vetement $vetements,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $favorite = new FavoriteProduct();

        $favorite->setCreatedAt(new DateTime());

        $favorite->setUser($this->getUser());

        $favorite->setVetement($vetements);

        $entityManager->persist($favorite);

        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    
    }

    #[Route('/remove-favorite/vetement-{id}', name: 'remove_favorite_vetement', methods:['GET', 'POST'])]
    public function removeFavoriteVetement(
        Vetement $vetement,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findOneBy(['user' => $this->getUser(), 'vetement' => $vetement]);

        $entityManager->remove($userFavorites);
        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    
    }

    #[Route('/add-favorite/bijoux-{id}', name: 'add_favorite_bijoux', methods:['GET', 'POST'])]
    public function addFavoriteBijoux(
        Bijoux $bijoux,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $favorite = new FavoriteProduct();

        $favorite->setCreatedAt(new DateTime());

        $favorite->setUser($this->getUser());

        $favorite->setBijoux($bijoux);

        $entityManager->persist($favorite);

        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    
    }

    #[Route('/remove-favorite/bijoux-{id}', name: 'remove_favorite_bijoux', methods:['GET', 'POST'])]
    public function removeFavoriteBijoux(
        Bijoux $bijoux,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findOneBy(['user' => $this->getUser(), 'bijoux' => $bijoux]);

        $entityManager->remove($userFavorites);
        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    
    }

}
