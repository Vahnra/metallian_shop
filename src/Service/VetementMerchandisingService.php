<?php

namespace App\Service;

use App\Entity\Categorie;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\VetementMerchandisingRepository;

class VetementMerchandisingService
{
    public function __construct(
        private RequestStack $requestStack, 
        private VetementMerchandisingRepository $vetementMerchandisingRepository, 
        private PaginatorInterface $paginator)
    {
        
    }

    // default pagination
    public function getPaginatedVetements($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 52;

        $vetementQuery = $this->vetementMerchandisingRepository->findForPagination($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    public function getPaginatedVetementsSousCategorie($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 52;

        $vetementQuery = $this->vetementMerchandisingRepository->findForPaginationSousCategorie($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    // Filtered pagination
    public function getPaginatedVetementsFiltered($value, $color, $size, $material, $marque, $artist, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 52;

        $vetementQuery = $this->vetementMerchandisingRepository->findForPaginationFiltered($value, $color, $size, $material, $marque, $artist, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    // Filtered pagination
    public function getPaginatedVetementsSousCategoriesFiltered($value, $color, $size, $material, $marque, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 52;

        $vetementQuery = $this->vetementMerchandisingRepository->findForPaginationSousCategoriesFiltered($value, $color, $size, $material, $marque, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }
}