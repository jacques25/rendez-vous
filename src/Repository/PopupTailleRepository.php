<?php

namespace App\Repository;

use App\Entity\PopupTaille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PopupTaille|null find($id, $lockMode = null, $lockVersion = null)
 * @method PopupTaille|null findOneBy(array $criteria, array $orderBy = null)
 * @method PopupTaille[]    findAll()
 * @method PopupTaille[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PopupTailleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PopupTaille::class);
    }

    // /**
    //  * @return PopupTaille[] Returns an array of PopupTaille objects
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
    public function findOneBySomeField($value): ?PopupTaille
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
