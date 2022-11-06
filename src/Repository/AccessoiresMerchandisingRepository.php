<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\AccessoiresMerchandising;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AccessoiresMerchandising>
 *
 * @method AccessoiresMerchandising|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccessoiresMerchandising|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccessoiresMerchandising[]    findAll()
 * @method AccessoiresMerchandising[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccessoiresMerchandisingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccessoiresMerchandising::class);
    }

    public function add(AccessoiresMerchandising $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AccessoiresMerchandising $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
    * @return AccessoiresMerchandising[] Returns an array of Vetement objects
    */
   public function findSimilarItem($categorie, $sousCategorie): array
   {
       return $this->createQueryBuilder('v')
            ->andWhere('v.categorieMerchandising = :val')
            ->setParameter('val', $categorie)
            ->andWhere('v.sousCategorieMerchandising = :val2')
            ->setParameter('val2', $sousCategorie)
            ->leftJoin('v.accessoiresMerchandisingQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.id', 'DESC')
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
            ->leftJoin('v.accessoiresMerchandisingQuantities', 'vqc')
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
            ->leftJoin('v.accessoiresMerchandisingQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
    }

    //    Query pour le filtre categorie
    public function findForPaginationFiltered($value, $color, $material, $artist, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorieMerchandising = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.accessoiresMerchandisingQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.accessoiresMerchandisingQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($material != null) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', array($material));
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

    public function findForPaginationSousCategoriesFiltered($value, $color, $material, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorieMerchandising = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.accessoiresMerchandisingQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.accessoiresMerchandisingQuantities', 'vqc')
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

    public function search($mots)
    {
        $query = $this->createQueryBuilder('a');
        if ($mots != null) {
            $query
                ->andWhere('MATCH_AGAINST(a.title) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots)
                ->leftJoin('a.accessoiresMerchandisingQuantities', 'vqcs')
                ->andWhere('vqcs.stock IS NOT NULL')
                ->andWhere('vqcs.stock != 0');
        }

        return $query->getQuery()->getResult();
    }
    
    public function searchFilter($mots, $color, $material, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('a');
        if ($mots != null) {
            $qb
                ->andWhere('MATCH_AGAINST(a.title) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots)
                ->leftJoin('a.accessoiresMerchandisingQuantities', 'vqcs')
                ->andWhere('vqcs.stock IS NOT NULL')
                ->andWhere('vqcs.stock != 0');
        }

        if ($color != null) {
            $qb
                ->leftJoin('a.accessoiresMerchandisingQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', array($color));
        }

        if ($material != null) {
            $qb
                ->andWhere('a.material = :material')
                ->setParameter('material', array($material));
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

    public function newProducts()
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.accessoiresMerchandisingQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('a.createdAt', 'DESC');
      
        return $query->getQuery()->getResult();
    }

    public function findForPaginationFilteredNewProducts($color, $material, $priceMini, $priceMax)
    {
        $qb = $this->createQueryBuilder('v')
            ->leftJoin('v.accessoiresMerchandisingQuantities', 'vqcs')
            ->andWhere('vqcs.stock IS NOT NULL')
            ->andWhere('vqcs.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if ($color != null) {
            $qb
                ->leftJoin('v.accessoiresMerchandisingQuantities', 'vqc')
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

        return $qb->getQuery()->getResult();
    }
}
