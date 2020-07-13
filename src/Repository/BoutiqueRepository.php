<?php

namespace App\Repository;

use App\Entity\Boutique;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Boutique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boutique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boutique[]    findAll()
 * @method Boutique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoutiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boutique::class);
    }


    public function findBoutiqueWithCategory()
    {
       $qb = $this->createQueryBuilder('b')
            ->leftJoin('b.produits', 'p')
            ->addSelect('p')
             ->orderBy('b.rang', 'DESC')
             ->setMaxResults(5);
      return      $qb ->getQuery()
            ->getResult();
            
    }

    public function findProduitWithBoutique($boutique, $slug)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->select('b')
            ->leftJoin('b.produits', 'p')
            ->addSelect('p')
            ->where('b.slug = :boutique')
            ->orderBy('b.rang')
            ->andWhere('p.slug = :slug')
            ->setParameters([
                'boutique' => $boutique,
                'slug' => $slug
            ]);
   
        $qb->getQuery()
            ->getResult();
    }

    
}
