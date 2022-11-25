<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function ordersByDate($date1, $date2)
    {
        return $this->createQueryBuilder('u')
                ->andWhere('u.createdAt > :firstDate')
                ->andWhere('u.createdAt < :secondDate')
                ->setParameter('firstDate', $date1)
                ->setParameter('secondDate', $date2)
                ->getQuery()
                ->getResult()
        ;
    }

    public function userOrdersByDate($user, $date1, $date2)
    {
        $qb = $this->createQueryBuilder('o')
                ->andWhere('o.user = :user')
                ->setParameter('user', $user)
                ->andWhere('o.createdAt > :firstDate')
                ->andWhere('o.createdAt < :secondDate')
                ->setParameter('firstDate', $date1)
                ->setParameter('secondDate', $date2)
                ->orderBy('o.createdAt', 'DESC');

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Order[] Returns an array of Order objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
