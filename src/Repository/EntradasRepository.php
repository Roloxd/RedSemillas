<?php

namespace App\Repository;

use App\Entity\Entradas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entradas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entradas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entradas[]    findAll()
 * @method Entradas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntradasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entradas::class);
    }

    public function lastEntradaNumber(){

        return $this->createQueryBuilder('p')
            //->andWhere('p.numeroPasaporte')
            ->orderBy("p.id", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

    }

    // /**
    //  * @return Entradas[] Returns an array of Entradas objects
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
    public function findOneBySomeField($value): ?Entradas
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
