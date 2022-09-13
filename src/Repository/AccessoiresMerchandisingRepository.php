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

//    /**
//     * @return AccessoiresMerchandising[] Returns an array of AccessoiresMerchandising objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AccessoiresMerchandising
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    //    Fonction pour la pagination

   public function findForPagination($value): Query
   {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorieMerchandising = :val')
            ->setParameter('val', $value)
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
   }

   public function findForPaginationSousCategorie($value): Query
   {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorieMerchandising = :val')
            ->setParameter('val', $value)
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
   }

   //    Query pour le filtre categorie
   public function findForPaginationFiltered($value, $color, $material, $priceMini, $priceMax): Query
   {
       $qb = $this->createQueryBuilder('v')
           ->andWhere('v.categorieMerchandising = :val')
           ->setParameter('val', $value)
           ->orderBy('v.createdAt', 'DESC');

       if (isset($color)) {
           $qb
               ->andWhere('v.color = :color')
               ->setParameter('color', $color);
       }

       if (isset($size)) {
           $qb
               ->andWhere('v.size = :size')
               ->setParameter('size', $size);
       }

       if (isset($material)) {
           $qb
               ->andWhere('v.material = :material')
               ->setParameter('material', $material);
       }

       if (isset($marque)) {
           $qb
               ->andWhere('v.marques = :marques')
               ->setParameter('marques', $marque);
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
            ->orderBy('v.createdAt', 'DESC');

        if (isset($color)) {
            $qb
                ->andWhere('v.color = :color')
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

    public function search($mots)
    {
        $query = $this->createQueryBuilder('a');
        if($mots != null)
        {
            $query
                ->andWhere('MATCH_AGAINST(a.title) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);
        }

        return $query->getQuery()->getResult();
    }
}
