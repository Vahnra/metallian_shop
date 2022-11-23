<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function save(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Products[] Returns an array of Vetement objects
     */
    public function findByTwelveVetements($value): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Products[] Returns an array of Products objects
     */
    public function findSimilarItem($categorie, $sousCategorie): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $categorie)
            ->andWhere('v.sousCategorie = :val2')
            ->setParameter('val2', $sousCategorie)
            ->leftJoin('v.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    public function findForPagination($value): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
    }

    public function findForPaginationSousCategorie($value): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
    }

    // Query pour le filtre categorie
    public function findForPaginationFilteredByColor($value, $color, $size, $material, $marque, $artist, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size  != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material  != null) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', array($material));
        }

        if ($marque  != null) {
            $qb
                ->andWhere('v.marques = :marques')
                ->setParameter('marques', array($marque));
        }

        if ($artist  != null) {
            $qb
                ->andWhere('v.artist = :artist')
                ->setParameter('artist', array($artist));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery();
    }

    public function findForPaginationFiltered($value, $color, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery();
    }

    public function findForPaginationFilteredAccessoires($value, $color, $material, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($material != null) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', array($material));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }
                
        return $qb->getQuery();
    }

    public function findForPaginationFilteredChaussures($value, $color, $size, $material, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', array($material));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }
                
        return $qb->getQuery();
    }

    public function findForPaginationFilteredMedias($value, $musicType, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($musicType != null) {
            $qb
                ->andWhere('v.genre = :genre')
                ->setParameter('genre', array($musicType));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }
                
        return $qb->getQuery();
    }

    public function findForPaginationSousCategoriesFiltered($value, $color, $size, $material, $marque, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', array($material));
        }

        if ($marque != null) {
            $qb
                ->andWhere('v.marques = :marques')
                ->setParameter('marques', array($marque));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery();
    }

    public function findForPaginationSousCategoriesFilteredBijoux($value, $color, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery();
    }

    public function findForPaginationAccessoiresFilteredAccessoires($value, $color, $material, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color !=null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($material != null) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', array($material));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }
                
        return $qb->getQuery();
    }

    public function findForPaginationSousCategoriesFilteredChaussures($value, $color, $size, $material, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', array($material));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }
                
        return $qb->getQuery();
    }

    public function findForPaginationSousCategoriesFilteredMedias($value, $musicType, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($musicType != null) {
            $qb
                ->andWhere('v.genre = :genre')
                ->setParameter('genre', array($musicType));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }
                
        return $qb->getQuery();
    }

    public function newProducts()
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('a.createdAt', 'DESC');

        return $query->getQuery()->getResult();
    }

    public function findForPaginationFilteredNewProducts($color, $size, $material, $marque, $artist, $musicType, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('a.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('a.material = :material')
                ->setParameter('material', array($material));
        }

        if ($marque != null) {
            $qb
                ->andWhere('a.marques = :marques')
                ->setParameter('marques', array($marque));
        }

        if ($artist != null) {
            $qb
                ->andWhere('a.artist = :artist')
                ->setParameter('artist', array($artist));
        }

        if ($musicType != null) {
            $qb
                ->andWhere('a.genre = :genre')
                ->setParameter('genre', array($musicType));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('a.price > :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('a.price < :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('a.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery()->getResult();
    }

    // Query pour la recherche
    public function search($mots)
    {
        $qb = $this->createQueryBuilder('a');
        if ($mots != null) {
            $qb
                ->andWhere('MATCH_AGAINST(a.title) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots)
                ->leftJoin('a.productsQuantities', 'vqcs')
                ->andWhere('vqcs.stock IS NOT NULL')
                ->andWhere('vqcs.stock != 0');
        }

        return $qb->getQuery()->getResult();
    }

    public function searchFilter($mots, $color, $size, $material, $artist, $musicType, $marque, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('a');

        if ($mots != null) {
            $qb
                ->andWhere('MATCH_AGAINST(a.title) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots)
                ->leftJoin('a.productsQuantities', 'vqcs')
                ->andWhere('vqcs.stock IS NOT NULL')
                ->andWhere('vqcs.stock != 0');
        }

        if ($color != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('a.material = :material')
                ->setParameter('material', array($material));
        }

        if ($marque != null) {
            $qb
                ->andWhere('a.marques = :marques')
                ->setParameter('marques', array($marque));
        }

        if ($artist != null) {
            $qb
                ->andWhere('a.artist = :artist')
                ->setParameter('artist', array($artist));
        }

        if ($musicType != null) {
            $qb
                ->andWhere('a.genre = :genre')
                ->setParameter('genre', array($musicType));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('a.price > :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('a.price < :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('a.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery()->getResult();
    }

    public function brandsProducts()
    {
        $query = $this->createQueryBuilder('a')
            ->andWhere('a.marques IS NOT NULL')
            ->leftJoin('a.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('a.createdAt', 'DESC');

        return $query->getQuery()->getResult();
    }
    
    public function findForPaginationFilteredBrands($color, $size, $material, $marque, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.marques IS NOT NULL')
            ->leftJoin('a.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('a.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('a.material = :material')
                ->setParameter('material', array($material));
        }

        if ($marque != null) {
            $qb
                ->andWhere('a.marques = :marques')
                ->setParameter('marques', array($marque));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('a.price > :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('a.price < :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('a.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery()->getResult();
    }

    public function specificBrandsProducts($brand)
    {
        $query = $this->createQueryBuilder('a')
            ->andWhere('a.marques IS NOT NULL')
            ->andWhere('a.marques= :brand')
            ->setParameter('brand', $brand)
            ->leftJoin('a.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('a.createdAt', 'DESC');

        return $query->getQuery()->getResult();
    }

    public function findForPaginationFilteredSpecificBrands($brand, $color, $size, $material, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.marques IS NOT NULL')
            ->andWhere('a.marques= :brand')
            ->setParameter('brand', $brand)
            ->leftJoin('a.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('a.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('a.material = :material')
                ->setParameter('material', array($material));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('a.price > :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('a.price < :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('a.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery()->getResult();
    }

    public function findForPaginationMerchandising($value): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorieMerchandising = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
    }

    public function findForPaginationMerchandisingFiltered($value, $color, $size, $material, $marque, $artist, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorieMerchandising = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', array($material));
        }

        if ($marque != null) {
            $qb
                ->andWhere('v.marques = :marques')
                ->setParameter('marques', array($marque));
        }

        if ($artist != null) {
            $qb
                ->andWhere('v.artist = :artist')
                ->setParameter('artist', array($artist));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price > :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price < :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery();
    }

    public function findForPaginationSousCategorieMerchandising($value): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorieMerchandising = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
    }

    public function findForPaginationSousCategoriesFilteredMerchandising($value, $color, $size, $material, $marque, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorieMerchandising = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('v.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', array($material));
        }

        if ($marque != null) {
            $qb
                ->andWhere('v.marques = :marques')
                ->setParameter('marques', array($marque));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('v.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('v.price > :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('v.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery();
    }

    public function findForPaginationSoldesProducts(): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->leftJoin('v.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->andWhere('vqc.solde = :value')
            ->setParameter('value', 'yes')
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
    }

    public function findForPaginationSoldesProductsCategory($category): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :category')
            ->setParameter('category', $category)
            ->leftJoin('v.productsQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->andWhere('vqc.solde = :value')
            ->setParameter('value', 'yes')
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
    }

    public function findForPaginationSoldesProductsFiltered($color, $size, $material, $marque, $artist, $musicType, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->andWhere('vqcs.solde = :value')
            ->setParameter('value', 'yes')
            ->orderBy('a.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('a.material = :material')
                ->setParameter('material', array($material));
        }

        if ($marque != null) {
            $qb
                ->andWhere('a.marques = :marques')
                ->setParameter('marques', array($marque));
        }

        if ($artist != null) {
            $qb
                ->andWhere('a.artist = :artist')
                ->setParameter('artist', array($artist));
        }

        if ($musicType != null) {
            $qb
                ->andWhere('a.genre = :genre')
                ->setParameter('genre', array($musicType));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('a.price > :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('a.price < :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('a.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery()->getResult();
    }

    public function findForPaginationSoldesProductsCategoryFiltered($category, $color, $size, $material, $marque, $artist, $musicType, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.categorie = :category')
            ->setParameter('category', $category)
            ->leftJoin('a.productsQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->andWhere('vqcs.solde = :value')
            ->setParameter('value', 'yes')
            ->orderBy('a.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('a.productsQuantities', 'vqs')
                ->andWhere('vqs.size = :size')
                ->setParameter('size', array($size));
        }

        if ($material != null) {
            $qb
                ->andWhere('a.material = :material')
                ->setParameter('material', array($material));
        }

        if ($marque != null) {
            $qb
                ->andWhere('a.marques = :marques')
                ->setParameter('marques', array($marque));
        }

        if ($artist != null) {
            $qb
                ->andWhere('a.artist = :artist')
                ->setParameter('artist', array($artist));
        }

        if ($musicType != null) {
            $qb
                ->andWhere('a.genre = :genre')
                ->setParameter('genre', array($musicType));
        }

        if (isset($priceMini)) {
            $qb
                ->andWhere('a.price > :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('a.price < :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if (isset($priceMini) && isset($priceMax)) {
            $qb
                ->andWhere('a.price BETWEEN :priceMax AND :priceMini')
                ->setParameter('priceMax', $priceMax)
                ->setParameter('priceMini', $priceMini);
        }

        return $qb->getQuery()->getResult();
    }
}