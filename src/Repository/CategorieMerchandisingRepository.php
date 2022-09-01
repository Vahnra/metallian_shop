<?php

namespace App\Repository;

use App\Entity\CategorieMerchandising;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieMerchandising>
 *
 * @method CategorieMerchandising|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieMerchandising|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieMerchandising[]    findAll()
 * @method CategorieMerchandising[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieMerchandisingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieMerchandising::class);
    }

    public function add(CategorieMerchandising $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategorieMerchandising $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CategorieMerchandising[] Returns an array of CategorieMerchandising objects
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

//    public function findOneBySomeField($value): ?CategorieMerchandising
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
