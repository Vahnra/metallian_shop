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

    //    Fonction pour la pagination

   public function findForPagination($value): Query
   {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.categorie = :val')
            ->setParameter('val', $value)
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
   }

   public function findForPaginationSousCategorie($value): Query
   {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.sousCategorie = :val')
            ->setParameter('val', $value)
            ->orderBy('v.createdAt', 'DESC');

        return $qb->getQuery();
   }

//    /**
//     * @return Accessoires[] Returns an array of Accessoires objects
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

//    public function findOneBySomeField($value): ?Accessoires
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
