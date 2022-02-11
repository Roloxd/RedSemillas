<?php

namespace App\Repository;

use App\Entity\MetodoEmpleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MetodoEmpleado|null find($id, $lockMode = null, $lockVersion = null)
 * @method MetodoEmpleado|null findOneBy(array $criteria, array $orderBy = null)
 * @method MetodoEmpleado[]    findAll()
 * @method MetodoEmpleado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetodoEmpleadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MetodoEmpleado::class);
    }

    // /**
    //  * @return MetodoEmpleado[] Returns an array of MetodoEmpleado objects
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
    public function findOneBySomeField($value): ?MetodoEmpleado
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
