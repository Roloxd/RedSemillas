<?php

namespace App\Repository;

use App\Entity\UsoVariedad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UsoVariedad|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsoVariedad|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsoVariedad[]    findAll()
 * @method UsoVariedad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsoVariedadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsoVariedad::class);
    }

    // /**
    //  * @return UsoVariedad[] Returns an array of UsoVariedad objects
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
    public function findOneBySomeField($value): ?UsoVariedad
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
