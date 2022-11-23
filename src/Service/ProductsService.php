<?php

namespace App\Service;

use App\Repository\ProductsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ProductsService
{
    public function __construct(
        private RequestStack $requestStack, 
        private ProductsRepository $productsRepository, 
        private PaginatorInterface $paginator)
    {
        
    }

    public function getPaginatedProducts($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPagination($value);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedProductsSousCategorie($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $vetementQuery = $this->productsRepository->findForPaginationSousCategorie($value);

        return $this->paginator->paginate($vetementQuery, $page, $limit);
    }

    public function getPaginatedVetementsFilteredByColor($value, $color, $size, $material, $marque, $artist, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationFilteredByColor($value, $color, $size, $material, $marque, $artist, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedBijouxFiltered($value, $color, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationFiltered($value, $color, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedAccessoiresFiltered($value, $color, $material, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationFilteredAccessoires($value, $color, $material, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedChaussuresFiltered($value, $color, $size, $material, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationFilteredChaussures($value, $color, $size, $material, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedMediaFiltered($value, $musicType, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationFilteredMedias($value, $musicType, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedVetementsSousCategoriesFiltered($value, $color, $size, $material, $marque, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationSousCategoriesFiltered($value, $color, $size, $material, $marque, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedBijouxSousCategoriesFiltered($value, $color, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationSousCategoriesFilteredBijoux($value, $color, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedAccessoiresSousCategoriesFiltered($value, $color, $material, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationAccessoiresFilteredAccessoires($value, $color, $material, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedChaussuresSousCategoriesFiltered($value, $color, $size, $material, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationSousCategoriesFilteredChaussures($value, $color, $size, $material, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedMediaSousCategoriesFiltered($value, $musicType, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationSousCategoriesFilteredMedias($value, $musicType, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedProductsMerchandising($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationMerchandising($value);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedProductsMerchandisingFiltered($value, $color, $size, $material, $marque, $artist, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationMerchandisingFiltered($value, $color, $size, $material, $marque, $artist, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedProductsSousCategorieMerchandising($value)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationSousCategorieMerchandising($value);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedProductsSousCategoriesMerchandisingFiltered($value, $color, $size, $material, $marque, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationSousCategoriesFilteredMerchandising($value, $color, $size, $material, $marque, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedSoldesProducts()
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationSoldesProducts();

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedSoldesProductsCategory($category)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationSoldesProductsCategory($category);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedSoldesProductsFiltered($color, $size, $material, $marque, $artist, $musicType, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationSoldesProductsFiltered($color, $size, $material, $marque, $artist, $musicType, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }

    public function getPaginatedSoldesProductsCategoryFiltered($category, $color, $size, $material, $marque, $artist, $musicType, $priceMini, $priceMax)
    {
        $request = $this->requestStack->getMainRequest();

        $page = $request->query->getInt('page', 1);
        $limit = 50;

        $productQuery = $this->productsRepository->findForPaginationSoldesProductsCategoryFiltered($category, $color, $size, $material, $marque, $artist, $musicType, $priceMini, $priceMax);

        return $this->paginator->paginate($productQuery, $page, $limit);
    }
}