<?php

namespace App\Repository;

use App\Entity\DataShop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DataShop|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataShop|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataShop[]    findAll()
 * @method DataShop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataShopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataShop::class);
    }

    // /**
    //  * @return DataShop[] Returns an array of DataShop objects
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
    public function findOneBySomeField($value): ?DataShop
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
