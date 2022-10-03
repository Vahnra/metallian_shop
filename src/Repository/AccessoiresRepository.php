<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Accessoires;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Accessoires>
 *
 * @method Accessoires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accessoires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accessoires[]    findAll()
 * @method Accessoires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccessoiresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accessoires::class);
    }

    public function add(Accessoires $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Accessoires $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Vetement[] Returns an array of Vetement objects
    */
    public function findSimilarItem($categorie, $sousCategorie): array
    {
        return $this->createQueryBuilder('v')
                ->andWhere('v.categorie = :val')
                ->setParameter('val', $categorie)
                ->andWhere('v.sousCategorie = :val2')
                ->setParameter('val2', $sousCategorie)
                ->leftJoin('v.accessoiresQuantities', 'vqc')
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
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.accessoiresQuantities', 'vqc')
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
            ->leftJoin('v.accessoiresQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
   }

    //    Query pour le filtre
    public function findForPaginationFiltered($value, $color, $material, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.accessoiresQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if (isset($color)) {
            $qb
                ->leftJoin('v.accessoiresQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', $color);
        }

        if (isset($material)) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', $material);
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

    //    Query pour le filtre
    public function findForPaginationAccessoiresFiltered($value, $color, $material, $priceMini, $priceMax): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorie = :val')
            ->setParameter('val', $value)
            ->leftJoin('v.accessoiresQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('v.createdAt', 'DESC');

        if (isset($color)) {
            $qb
                ->leftJoin('v.accessoiresQuantities', 'vqc')
                ->andWhere('vqc.color = :color')
                ->setParameter('color', $color);
        }

        if (isset($material)) {
            $qb
                ->andWhere('v.material = :material')
                ->setParameter('material', $material);
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

    // Query pour la barre de recherche
    public function search($mots)
    {
        $query = $this->createQueryBuilder('a');
        if($mots != null)
        {
            $query
                ->andWhere('MATCH_AGAINST(a.title) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots)
                ->leftJoin('a.accessoiresQuantities', 'vqc')
                ->andWhere('vqc.stock IS NOT NULL')
                ->andWhere('vqc.stock != 0');
        }

        return $query->getQuery()->getResult();
    }

    public function newProducts()
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.accessoiresQuantities', 'vqc')
            ->andWhere('vqc.stock IS NOT NULL')
            ->andWhere('vqc.stock != 0')
            ->orderBy('a.createdAt', 'DESC');
      
        return $query->getQuery()->getResult();
    }
}
