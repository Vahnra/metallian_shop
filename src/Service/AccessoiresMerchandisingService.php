<?php

namespace App\Service;

use App\Repository\AccessoiresRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\AccessoiresMerchandisingRepository;

class AccessoiresMerchandisingService
{
    public function __construct(
        private RequestStack $requestStack, 
        private AccessoiresMerchandisingRepository $bijouxRepository, 
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

    // Filtered pagination
    public function getPaginatedAccessoiresFiltered($value, $color, $material, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->bijouxRepository->findForPaginationFiltered($value, $color, $material, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    // Filtered pagination
    public function getPaginatedAccessoiresSousCategoriesFiltered($value, $color, $material, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 8;

        $vetementQuery = $this->bijouxRepository->findForPaginationAccessoiresFiltered($value, $color, $material, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }
}