<?php

namespace App\Repository;

use App\Entity\PropertiesBijou;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PropertiesBijou|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertiesBijou|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertiesBijou[]    findAll()
 * @method PropertiesBijou[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertiesBijouRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertiesBijou::class);
    }

    // /**
    //  * @return PropertiesBijou[] Returns an array of PropertiesBijou objects
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
    public function findOneBySomeField($value): ?PropertiesBijou
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