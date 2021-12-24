<?php

namespace App\Repository;

use App\Entity\ImagenSeleccionada;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImagenSeleccionada|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagenSeleccionada|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagenSeleccionada[]    findAll()
 * @method ImagenSeleccionada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagenSeleccionadaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagenSeleccionada::class);
    }

    // /**
    //  * @return ImagenSeleccionada[] Returns an array of ImagenSeleccionada objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImagenSeleccionada
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return ImagenSeleccionada[]
     */
    public function findIdImagenesVariedad(int $variedad_id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT i.id
            FROM App\Entity\ImagenSeleccionada i
            WHERE i.variedad = :variedad_id'
        )->setParameter('variedad_id', $variedad_id);

        return $query->getResult();
    }
}
