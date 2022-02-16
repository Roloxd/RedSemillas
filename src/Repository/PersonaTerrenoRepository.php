<?php

namespace App\Repository;

use App\Entity\PersonaTerreno;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersonaTerreno|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonaTerreno|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonaTerreno[]    findAll()
 * @method PersonaTerreno[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonaTerrenoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonaTerreno::class);
    }

    // /**
    //  * @return PersonaTerreno[] Returns an array of PersonaTerreno objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonaTerreno
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
