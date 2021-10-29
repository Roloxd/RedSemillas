<?php

namespace App\Repository;

use App\Entity\Uso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Uso|null find($id, $lockMode = null, $lockVersion = null)
 * @method Uso|null findOneBy(array $criteria, array $orderBy = null)
 * @method Uso[]    findAll()
 * @method Uso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Uso::class);
    }

    // /**
    //  * @return Uso[] Returns an array of Uso objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Uso
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
