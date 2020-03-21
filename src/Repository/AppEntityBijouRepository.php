<?php

namespace App\Repository;

use App\Entity\AppEntityBijou;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AppEntityBijou|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppEntityBijou|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppEntityBijou[]    findAll()
 * @method AppEntityBijou[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppEntityBijouRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppEntityBijou::class);
    }

    // /**
    //  * @return AppEntityBijou[] Returns an array of AppEntityBijou objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppEntityBijou
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
