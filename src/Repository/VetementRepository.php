<?php

namespace App\Repository;

use App\Entity\Vetement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vetement>
 *
 * @method Vetement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vetement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vetement[]    findAll()
 * @method Vetement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VetementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vetement::class);
    }

    public function add(Vetement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vetement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Vetement[] Returns an array of Vetement objects
    */
   public function findByFourVetements($value): array
   {
       return $this->createQueryBuilder('v')
           ->andWhere('v.categorie = :val')
           ->setParameter('val', $value)
           ->orderBy('v.id', 'DESC')
           ->setMaxResults(4)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Vetement
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
