<?php

namespace App\Repository;

use App\Entity\Donante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Donante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Donante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Donante[]    findAll()
 * @method Donante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Donante::class);
    }

    // /**
    //  * @return Donante[] Returns an array of Donante objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Donante
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
