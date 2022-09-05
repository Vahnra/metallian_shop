<?php

namespace App\Service;

use App\Repository\AccessoiresRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AccessoiresService
{
    public function __construct(
        private RequestStack $requestStack, 
        private AccessoiresRepository $bijouxRepository, 
        private PaginatorInterface $paginator)
    {
        
    }

    public function getPaginatedAccessoires($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->bijouxRepository->findForPagination($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    public function getPaginatedAccessoiresSousCategorie($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->bijouxRepository->findForPaginationSousCategorie($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }
}