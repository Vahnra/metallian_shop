<?php

namespace App\Repository;

use App\Entity\VetementMerchandisingQuantity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VetementMerchandisingQuantity>
 *
 * @method VetementMerchandisingQuantity|null find($id, $lockMode = null, $lockVersion = null)
 * @method VetementMerchandisingQuantity|null findOneBy(array $criteria, array $orderBy = null)
 * @method VetementMerchandisingQuantity[]    findAll()
 * @method VetementMerchandisingQuantity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VetementMerchandisingQuantityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VetementMerchandisingQuantity::class);
    }

    public function add(VetementMerchandisingQuantity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VetementMerchandisingQuantity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VetementMerchandisingQuantity[] Returns an array of VetementMerchandisingQuantity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VetementMerchandisingQuantity
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
