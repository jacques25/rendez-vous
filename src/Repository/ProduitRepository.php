<?php

namespace App\Repository;

use App\Entity\Produit;

use App\Entity\Boutique;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }


    // public function findByBoutique($slug)
    // {
    //     $qb = $this->createQueryBuilder('p');
    //     $qb
    //         ->leftJoin('p.boutiques', 'b')
    //         ->select('p, b')
    //         ->where('b.slug = :slug')
    //         ->setParameter('slug', $slug);
    //     return $qb->getQuery()->getResult();
    // }
}
