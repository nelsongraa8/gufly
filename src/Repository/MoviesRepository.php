<?php

namespace App\Repository;

use App\Entity\Movies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movies[]    findAll()
 * @method Movies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Movies[]    findAllNombreSearch()
 * @method Movies[]    findLastMovies() 
 */
class MoviesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movies::class);
    }


    /** Metodo con el que se encuentra las peliculas por su nombre en la DB de Gufly */
    /**
     * @return Movies[] Returns an array of Movies objects
     */
    public function findAllNombreSearch( $value )
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.nombre LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findLastMovies()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.activate = :val')
            ->setParameter('val', true)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findAllMovies( $val_limit )
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.activate = :val')
            ->setParameter('val', true)
            ->andWhere('m.id < :val2')
            ->setParameter('val2', $val_limit)
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

}