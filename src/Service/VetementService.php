<?php

namespace App\Service;

use App\Entity\Categorie;
use App\Repository\VetementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class VetementService
{
    public function __construct(
        private RequestStack $requestStack, 
        private VetementRepository $vetementRepository, 
        private PaginatorInterface $paginator)
    {
        
    }

    // default pagination
    public function getPaginatedVetements($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $vetementQuery = $this->vetementRepository->findForPagination($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    public function getPaginatedVetementsSousCategorie($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $vetementQuery = $this->vetementRepository->findForPaginationSousCategorie($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    // Filtered pagination
    public function getPaginatedVetementsFilteredByColor($value, $color, $size, $material, $marque, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $vetementQuery = $this->vetementRepository->findForPaginationFilteredByColor($value, $color, $size, $material, $marque, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    // Filtered pagination
    public function getPaginatedVetementsSousCategoriesFiltered($value, $color, $size, $material, $marque, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $vetementQuery = $this->vetementRepository->findForPaginationSousCategoriesFiltered($value, $color, $size, $material, $marque, $priceMini, $priceMax);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }
}