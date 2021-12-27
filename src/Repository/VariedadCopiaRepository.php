<?php

namespace App\Repository;

use App\Entity\VariedadCopia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VariedadCopia|null find($id, $lockMode = null, $lockVersion = null)
 * @method VariedadCopia|null findOneBy(array $criteria, array $orderBy = null)
 * @method VariedadCopia[]    findAll()
 * @method VariedadCopia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariedadCopiaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VariedadCopia::class);
    }

    // /**
    //  * @return Variedad[] Returns an array of Variedad objects
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
    public function findOneBySomeField($value): ?Variedad
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return VariedadCopia[]
     */
    public function findAllFamiliaGeneroEspecie(): array
    {
        // $entityManager = $this->getEntityManager()->getConnection();

        // $sql = 'SELECT DISTINCT tipo FROM taxon t';
        // $stmt = $entityManager->prepare($sql);

        // return $stmt->fetchAllAssociative();

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT v.id, v.familia, v.genero, v.especie
            FROM App\Entity\VariedadCopia v'
        );

        return $query->getResult();
    }
}
