<?php

namespace App\Repository;

use App\Entity\ShopData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShopData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopData[]    findAll()
 * @method ShopData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopData::class);
    }

    // /**
    //  * @return ShopData[] Returns an array of ShopData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShopData
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
