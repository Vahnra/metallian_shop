<?php

namespace App\Service;

use App\Repository\ChaussuresRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ChaussuresService
{
    public function __construct(
        private RequestStack $requestStack, 
        private ChaussuresRepository $chaussuresRepository, 
        private PaginatorInterface $paginator)
    {
        
    }

    public function getPaginatedChaussures($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->chaussuresRepository->findForPagination($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    public function getPaginatedChaussuresSousCategorie($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->chaussuresRepository->findForPaginationSousCategorie($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    // Filtered pagination
    public function getPaginatedChaussuresFiltered($value, $color, $size, $material, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->chaussuresRepository->findForPaginationFiltered($value, $color, $size, $material, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }
}