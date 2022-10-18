<?php

namespace App\Service;

use App\Repository\BijouxRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class BijouxService
{
    public function __construct(
        private RequestStack $requestStack, 
        private BijouxRepository $bijouxRepository, 
        private PaginatorInterface $paginator)
    {
        
    }

    public function getPaginatedBijoux($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $vetementQuery = $this->bijouxRepository->findForPagination($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    public function getPaginatedBijouxSousCategorie($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $vetementQuery = $this->bijouxRepository->findForPaginationSousCategorie($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    // Filtered pagination
    public function getPaginatedBijouxFiltered($value, $color, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $vetementQuery = $this->bijouxRepository->findForPaginationFiltered($value, $color, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    // Filtered pagination
    public function getPaginatedBijouxSousCategoriesFiltered($value, $color, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $vetementQuery = $this->bijouxRepository->findForPaginationSousCategoriesFiltered($value, $color, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }
}