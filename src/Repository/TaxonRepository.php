<?php

namespace App\Repository;

use App\Entity\Taxon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @method Taxon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Taxon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Taxon[]    findAll()
 * @method Taxon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Taxon::class);
    }

    // /**
    //  * @return Taxon[] Returns an array of Taxon objects
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
    public function findOneBySomeField($value): ?Taxon
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
     * @return Taxon[]
     */
    public function findAllFamilia(): array
    {
        // $entityManager = $this->getEntityManager()->getConnection();

        // $sql = 'SELECT DISTINCT tipo FROM taxon t';
        // $stmt = $entityManager->prepare($sql);

        // return $stmt->fetchAllAssociative();

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT t.tipo
            FROM App\Entity\Taxon t'
        );

        return $query->getResult();
    }

    /**
     * @return Taxon[]
     */
    public function findAllEspecie()
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.tipo = "SPECIES"');

        dump($qb->getQuery()->execute());
        return $qb->getQuery()->execute();
    }

    /**
     * @return Taxon[]
     */
    public function findEspecie(int $id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT t.nombre
            FROM App\Entity\Taxon t
            WHERE t.tipo = :especie AND t.id :id'
        )->setParameter('especie', "Especie")->setParameter('id', $id);

        return $query->getResult();
    }

    /**
     * @return Taxon[]
     */
    public function findHijosFamilia(int $padre): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT t.nombre
            FROM App\Entity\Taxon t
            WHERE t.tipo = :genero AND t.padre = :padre'
        )->setParameter('padre', $padre)->setParameter('genero', "Genero");

        return $query->getResult();
    }

    /**
     * @return Taxon[]
     */
    public function findHijosGenero(int $padre): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT t.nombre
            FROM App\Entity\Taxon t
            WHERE t.tipo = :genero AND t.padre = :padre'
        )->setParameter('padre', $padre)->setParameter('genero', "Especie");

        return $query->getResult();
    }

    /**
     * @return Taxon[]
     */
    public function findFamilias(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT t.nombre
            FROM App\Entity\Taxon t
            WHERE t.tipo = :tipo '
        )->setParameter('tipo', "Familia");

        return $query->getResult();
    }

    /**
     * @return Taxon[]
     */
    public function findId(string $nombre): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT t.id
            FROM App\Entity\Taxon t
            WHERE t.nombre = :nombre'
        )->setParameter('nombre', $nombre);

        return $query->getResult();
    }

    /**
     * @return Taxon[]
     */
    public function findIdWherePadre(int $id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT t.id
            FROM App\Entity\Taxon t
            WHERE t.padre = :padre'
        )->setParameter('padre', $id);

        return $query->getResult();
    }
}
