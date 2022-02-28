<?php

namespace App\Repository;

use App\Entity\Variedad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Variedad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Variedad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Variedad[]    findAll()
 * @method Variedad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariedadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Variedad::class);
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
     * @return Variedad[]
     */
    public function findCodigo(string $codigo): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT v.nombreComun, v.codigo
            FROM App\Entity\Variedad v
            WHERE v.codigo = :codigo'
        )->setParameter('codigo', $codigo);

        return $query->getResult();
    }

    /**
     * @return Variedad[]
     */
    public function whereEspecies(array $idEspecies): array
    {
        $arrayIdsVariedades = [];
        $entityManager = $this->getEntityManager();

        foreach($idEspecies as $idEspecie){
            $query = $entityManager->createQuery(
                'SELECT v.id
                FROM App\Entity\Variedad v
                WHERE v.especie = :especie'
            )->setParameter('especie', $idEspecie);

            $arrayIdsVariedades[] = $query->getResult();
        }

        return $arrayIdsVariedades;
    }
}
