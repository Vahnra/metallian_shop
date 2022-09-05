<?php

namespace App\Service;

use App\Entity\Categorie;
use App\Repository\MediaRepository;
use App\Repository\VetementRepository;
use App\Repository\ChaussuresRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ChaussuresService
{
    public function __construct(
        private RequestStack $requestStack, 
        private ChaussuresRepository $vetementRepository, 
        private PaginatorInterface $paginator)
    {
        
    }

    public function getPaginatedChaussures($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->vetementRepository->findForPagination($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    public function getPaginatedChaussuresSousCategorie($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->vetementRepository->findForPaginationSousCategorie($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }
}