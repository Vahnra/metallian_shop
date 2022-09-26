<?php

namespace App\Controller;

use DateTime;
use App\Entity\Media;
use App\Entity\Bijoux;
use App\Entity\Vetement;
use App\Entity\Chaussures;
use App\Entity\Accessoires;
use App\Entity\FavoriteProduct;
use App\Entity\VetementMerchandising;
use App\Entity\AccessoiresMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteProductController extends AbstractController
{
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

    #[Route('/add-favorite/media-{id}', name: 'add_favorite_media', methods:['GET', 'POST'])]
    public function addFavoriteMedia(
        Media $media,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $favorite = new FavoriteProduct();

        $favorite->setCreatedAt(new DateTime());

        $favorite->setUser($this->getUser());

        $favorite->setMedia($media);

        $entityManager->persist($favorite);

        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    
    }

    #[Route('/remove-favorite/media-{id}', name: 'remove_favorite_media', methods:['GET', 'POST'])]
    public function removeFavoriteMedia(
        Media $media,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findOneBy(['user' => $this->getUser(), 'media' => $media]);

        $entityManager->remove($userFavorites);
        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    
    }

    #[Route('/add-favorite/chaussures-{id}', name: 'add_favorite_chaussures', methods:['GET', 'POST'])]
    public function addFavoriteChaussures(
        Chaussures $chaussures,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $favorite = new FavoriteProduct();

        $favorite->setCreatedAt(new DateTime());

        $favorite->setUser($this->getUser());

        $favorite->setChaussures($chaussures);

        $entityManager->persist($favorite);

        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    
    }

    #[Route('/remove-favorite/chaussures-{id}', name: 'remove_favorite_chaussures', methods:['GET', 'POST'])]
    public function removeFavoriteChaussures(
        Chaussures $chaussures,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findOneBy(['user' => $this->getUser(), 'chaussures' => $chaussures]);

        $entityManager->remove($userFavorites);
        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);

    }

    #[Route('/add-favorite/accessoires-{id}', name: 'add_favorite_accessoires', methods:['GET', 'POST'])]
    public function addFavoriteAccessoires(
        Accessoires $accessoires,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $favorite = new FavoriteProduct();

        $favorite->setCreatedAt(new DateTime());

        $favorite->setUser($this->getUser());

        $favorite->setAccessoires($accessoires);

        $entityManager->persist($favorite);

        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    
    }

    #[Route('/remove-favorite/accessoires-{id}', name: 'remove_favorite_accessoires', methods:['GET', 'POST'])]
    public function removeFavoriteAccessoires(
        Accessoires $accessoires,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findOneBy(['user' => $this->getUser(), 'accessoires' => $accessoires]);

        $entityManager->remove($userFavorites);
        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);

    }

    #[Route('/add-favorite/merchandising-vetement-{id}', name: 'add_favorite_vetement_merchandising', methods:['GET', 'POST'])]
    public function addFavoriteVetementMerchandising(
        VetementMerchandising $vetementMerchandising,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $favorite = new FavoriteProduct();

        $favorite->setCreatedAt(new DateTime());

        $favorite->setUser($this->getUser());

        $favorite->setVetementMerchandising($vetementMerchandising);

        $entityManager->persist($favorite);

        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    
    }

    #[Route('/remove-favorite/merchandising-vetement-{id}', name: 'remove_favorite_vetement_merchandising', methods:['GET', 'POST'])]
    public function removeFavoriteVetementMerchandising(
        VetementMerchandising $vetementMerchandising,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findOneBy(['user' => $this->getUser(), 'vetementMerchandising' => $vetementMerchandising]);

        $entityManager->remove($userFavorites);
        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);

    }

    #[Route('/add-favorite/merchandising-accessoires-{id}', name: 'add_favorite_accessoires_merchandising', methods:['GET', 'POST'])]
    public function addFavoriteAccessoiresMerchandising(
        AccessoiresMerchandising $accessoiresMerchandising,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $favorite = new FavoriteProduct();

        $favorite->setCreatedAt(new DateTime());

        $favorite->setUser($this->getUser());

        $favorite->setAccessoiresMerchandising($accessoiresMerchandising);

        $entityManager->persist($favorite);

        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    
    }

    #[Route('/remove-favorite/merchandising-accessoires-{id}', name: 'remove_favorite_accessoires_merchandising', methods:['GET', 'POST'])]
    public function removeFavoriteAccessoiresMerchandising(
        AccessoiresMerchandising $accessoiresMerchandising,
        EntityManagerInterface $entityManager,
        Request $request
        )
    {
        $userFavorites = $entityManager->getRepository(FavoriteProduct::class)->findOneBy(['user' => $this->getUser(), 'accessoiresMerchandising' => $accessoiresMerchandising]);

        $entityManager->remove($userFavorites);
        $entityManager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);

    }

}
