<?php

namespace App\Repository;

use App\Entity\Fitosanitario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fitosanitario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fitosanitario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fitosanitario[]    findAll()
 * @method Fitosanitario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FitosanitarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fitosanitario::class);
    }

    // /**
    //  * @return Fitosanitario[] Returns an array of Fitosanitario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fitosanitario
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
