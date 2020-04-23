<?php

namespace App\Repository;

use App\Entity\DescriptionProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DescriptionProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method DescriptionProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method DescriptionProduit[]    findAll()
 * @method DescriptionProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescriptionProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DescriptionProduit::class);
    }
  
public function findByBoutique(array $boutique,  $produit) {

        $qb = $this->createQueryBuilder('d');
        $qb->leftJoin('d.boutiques', 'bt')
                ->addSelect('bt')
                ->where($qb->expr()->in('bt.title', $boutique))
                ->leftJoin('d.produits', 'p')
                ->addSelect('p')
                ->andWhere('p.id = :id')
                ->setParameter('id', $produit)
        ;

        return $qb->getQuery()->getResult();
    }
    // /**
    //  * @return DescriptionProduit[] Returns an array of DescriptionProduit objects
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
    public function findOneBySomeField($value): ?DescriptionProduit
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
