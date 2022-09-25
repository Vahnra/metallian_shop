<?php

namespace App\Repository;

use App\Entity\ChaussuresQuantity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChaussuresQuantity>
 *
 * @method ChaussuresQuantity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChaussuresQuantity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChaussuresQuantity[]    findAll()
 * @method ChaussuresQuantity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChaussuresQuantityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChaussuresQuantity::class);
    }

    public function add(ChaussuresQuantity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ChaussuresQuantity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ChaussuresQuantity[] Returns an array of ChaussuresQuantity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ChaussuresQuantity
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
