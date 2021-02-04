<?php

namespace App\Repository;

use App\Entity\Comentary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comentary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comentary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comentary[]    findAll()
 * @method Comentary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComentaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comentary::class);
    }

    // /**
    //  * @return Comentary[] Returns an array of Comentary objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comentary
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
