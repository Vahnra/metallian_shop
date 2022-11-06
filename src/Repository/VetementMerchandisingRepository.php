<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\VetementMerchandising;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<VetementMerchandising>
 *
 * @method VetementMerchandising|null find($id, $lockMode = null, $lockVersion = null)
 * @method VetementMerchandising|null findOneBy(array $criteria, array $orderBy = null)
 * @method VetementMerchandising[]    findAll()
 * @method VetementMerchandising[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VetementMerchandisingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VetementMerchandising::class);
    }

    public function add(VetementMerchandising $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VetementMerchandising $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return VetementMerchandising[] Returns an array of Vetement objects
    */
   public function findSimilarItem($categorie, $sousCategorie): array
   {
       return $this->createQueryBuilder('v')
            ->andWhere('v.categorieMerchandising = :val')
            ->setParameter('val', $categorie)
            ->andWhere('v.sousCategorieMerchandising = :val2')
            ->setParameter('val2', $sousCategorie)
            ->leftJoin('v.vetementMerchandisingQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
   }

    //    Fonction pour la pagination
    public function findForPagination($value): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorieMerchandising = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.vetementMerchandisingQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
    }

    public function findForPaginationSousCategorie($value): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorieMerchandising = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.vetementMerchandisingQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
    }

    //    Query pour le filtre categorie
    public function findForPaginationFiltered($value, $color, $size, $material, $marque, $artist, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorieMerchandising = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.vetementMerchandisingQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.vetementMerchandisingQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('v.vetementMerchandisingQuantities', 'vqs')
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

    public function findForPaginationSousCategoriesFiltered($value, $color, $size, $material, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorieMerchandising = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.vetementMerchandisingQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.vetementMerchandisingQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('v.vetementMerchandisingQuantities', 'vqs')
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

    public function search($mots)
    {
        $query = $this->createQueryBuilder('a');
        if ($mots != null) {
            $query
                ->andWhere('MATCH_AGAINST(a.title) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots)
                ->leftJoin('a.vetementMerchandisingQuantities', 'vqc')
                ->andWhere('vqc.stock IS NOT NULL')
                ->andWhere('vqc.stock != 0');
        }

        return $query->getQuery()->getResult();
    }

    public function newProducts()
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.vetementMerchandisingQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('a.createdAt', 'DESC');
      
        return $query->getQuery()->getResult();
    }

    public function brandsProducts()
    {
        $query = $this->createQueryBuilder('a')
            ->andWhere('a.marques IS NOT NULL')
            ->leftJoin('a.vetementMerchandisingQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('a.createdAt', 'DESC');
      
        return $query->getQuery()->getResult();
    }

    public function specificBrandsProducts($brand)
    {
        $query = $this->createQueryBuilder('a')
            ->andWhere('a.marques IS NOT NULL')
            ->andWhere('a.marques= :brand')
            ->setParameter('brand', $brand)
            ->leftJoin('a.vetementMerchandisingQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('a.createdAt', 'DESC');
      
        return $query->getQuery()->getResult();
    }

    public function findForPaginationFilteredBrands($color, $size, $material, $marque, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.marques IS NOT NULL')
            ->leftJoin('a.vetementMerchandisingQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('a.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('a.vetementMerchandisingQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('a.vetementMerchandisingQuantities', 'vqs')
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

    public function findForPaginationFilteredSpecificBrands($brand, $color, $size, $material, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.marques IS NOT NULL')
            ->andWhere('a.marques= :brand')
            ->setParameter('brand', $brand)
            ->leftJoin('a.vetementMerchandisingQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('a.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('a.vetementMerchandisingQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('a.vetementMerchandisingQuantities', 'vqs')
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

    public function findForPaginationFilteredNewProducts($color, $size, $material, $marque, $artist, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('v')
            ->leftJoin('v.vetementMerchandisingQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.vetementMerchandisingQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('v.vetementMerchandisingQuantities', 'vqs')
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

        return $qb->getQuery()->getResult();
    }

    public function searchFilter($mots, $color, $size, $material, $marque, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('a');
        if ($mots != null) {
            $qb
                ->andWhere('MATCH_AGAINST(a.title) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots)
                ->leftJoin('a.vetementMerchandisingQuantities', 'vqcs')
                ->andWhere('vqcs.stock IS NOT NULL')
                ->andWhere('vqcs.stock != 0');
        }

        if ($color != null) {
            $qb
                ->leftJoin('a.vetementMerchandisingQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($size != null) {
            $qb
                ->leftJoin('a.vetementMerchandisingQuantities', 'vqs')
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
                ->andWhere('a.price < :priceMini')
                ->setParameter('priceMini', $priceMini);
        }

        if (isset($priceMax)) {
            $qb
                ->andWhere('a.price > :priceMax')
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
