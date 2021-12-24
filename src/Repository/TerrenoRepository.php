<?php

namespace App\Repository;

use App\Entity\Terreno;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Terreno|null find($id, $lockMode = null, $lockVersion = null)
 * @method Terreno|null findOneBy(array $criteria, array $orderBy = null)
 * @method Terreno[]    findAll()
 * @method Terreno[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerrenoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terreno::class);
    }

    // /**
    //  * @return Terreno[] Returns an array of Terreno objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Terreno
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Terreno[]
     */
    public function findTerrenosPersona(int $id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT t.id, t.nombre
            FROM App\Entity\Terreno t
            WHERE t.id_persona = :id'
        )->setParameter('id', $id);

        return $query->getResult();
    }
}
