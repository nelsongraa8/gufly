<?php

namespace App\Repository;

use App\Entity\Destacadas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Destacadas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Destacadas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Destacadas[]    findAll()
 * @method Destacadas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DestacadasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Destacadas::class);
    }

    // /**
    //  * @return Destacadas[] Returns an array of Destacadas objects
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
    public function findOneBySomeField($value): ?Destacadas
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
