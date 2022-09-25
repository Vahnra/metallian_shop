<?php

namespace App\Repository;

use App\Entity\AccessoiresMerchandisingQuantity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccessoiresMerchandisingQuantity>
 *
 * @method AccessoiresMerchandisingQuantity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccessoiresMerchandisingQuantity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccessoiresMerchandisingQuantity[]    findAll()
 * @method AccessoiresMerchandisingQuantity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccessoiresMerchandisingQuantityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccessoiresMerchandisingQuantity::class);
    }

    public function add(AccessoiresMerchandisingQuantity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AccessoiresMerchandisingQuantity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AccessoiresMerchandisingQuantity[] Returns an array of AccessoiresMerchandisingQuantity objects
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

//    public function findOneBySomeField($value): ?AccessoiresMerchandisingQuantity
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
