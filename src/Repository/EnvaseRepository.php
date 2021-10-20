<?php

namespace App\Repository;

use App\Entity\Envase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Envase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Envase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Envase[]    findAll()
 * @method Envase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnvaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Envase::class);
    }

    // /**
    //  * @return Envase[] Returns an array of Envase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Envase
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
