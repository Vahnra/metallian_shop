<?php

namespace App\Service;

use App\Entity\Categorie;
use App\Repository\MediaRepository;
use App\Repository\VetementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MediaService
{
    public function __construct(
        private RequestStack $requestStack, 
        private MediaRepository $vetementRepository, 
        private PaginatorInterface $paginator)
    {
        
    }

    public function getPaginatedMedias($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->vetementRepository->findForPagination($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    public function getPaginatedMediasSousCategorie($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->vetementRepository->findForPaginationSousCategorie($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }
    
    // Filtered pagination
    public function getPaginatedMediaFiltered($value, $musicType, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->vetementRepository->findForPaginationFiltered($value, $musicType, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    // Filtered pagination
    public function getPaginatedMediaSousCategoriesFiltered($value, $musicType, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->vetementRepository->findForPaginationSousCategoriesFiltered($value, $musicType, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }
}