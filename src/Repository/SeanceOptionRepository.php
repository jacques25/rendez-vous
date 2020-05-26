<?php

namespace App\Repository;

use App\Entity\SeanceOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SeanceOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method SeanceOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method SeanceOption[]    findAll()
 * @method SeanceOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeanceOption::class);
    }

  
    // /**
    //  * @return SeanceOption[] Returns an array of SeanceOption objects
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
    public function findOneBySomeField($value): ?SeanceOption
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
