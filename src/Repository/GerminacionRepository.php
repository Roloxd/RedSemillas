<?php

namespace App\Repository;

use App\Entity\Germinacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Germinacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Germinacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Germinacion[]    findAll()
 * @method Germinacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GerminacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Germinacion::class);
    }

    // /**
    //  * @return Germinacion[] Returns an array of Germinacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Germinacion
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
