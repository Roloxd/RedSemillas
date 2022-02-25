<?php

namespace App\Repository;

use App\Entity\Mejoras;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mejoras|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mejoras|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mejoras[]    findAll()
 * @method Mejoras[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MejorasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mejoras::class);
    }

    // /**
    //  * @return Mejoras[] Returns an array of Mejoras objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mejoras
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
