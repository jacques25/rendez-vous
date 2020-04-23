<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\RechercheBijou;
use App\Entity\Recherche;
use App\Entity\Produit;
use App\Entity\Bijou;
use App\Data\SearchData;

/**
 * @method Bijou|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bijou|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bijou[]    findAll()
 * @method Bijou[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BijouRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bijou::class);
    }




    /**
     * Undocumented function
     *
     * @param SearchData $data
     * @return Bijou[]
     */
    public function findSearch(SearchData $search): array
    {

        $query = $this
            ->createQueryBuilder('b')
            ->select('p', 'b', 'op')
            ->join('b.produits', 'p')
            ->join('b.option_bijou', 'op');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('b.title LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }
        if (!empty($search->min)) {
            $query = $query
                ->andWhere('op.prix >= :min')
                ->setParameter('min', $search->min);
        }
        if (!empty($search->max)) {
            $query = $query
                ->andWhere('op.prix <= :max')
                ->setParameter('max', $search->max);
        }

        if (!empty($search->promo)) {
            $query = $query
                ->andWhere('b.promo = 1');
        }

        if (!empty($search->produits)) {
            $query = $query
                ->andWhere('p.id IN (:produits)')
                ->setParameter('produits', $search->produits);
        }
        return $query->getQuery()->getResult();
    }


    public function findAllByBoutique(array $boutique, $produit)
    {

        $qb = $this->createQueryBuilder('b');
        $qb->leftJoin('b.boutiques', 'bt')
            ->addSelect('bt')
            ->where($qb->expr()->in('bt.title', $boutique))
            ->leftJoin('b.produits', 'p')
            ->addSelect('p')
            ->leftJoin('b.option_bijou', 'ob')
            ->addSelect('ob')
            ->leftJoin('b.pictures', 'pic')
            ->addSelect('pic')
            ->andWhere('p.id = :id')
            ->setParameter('id', $produit);


        return $qb->getQuery()->getResult();
    }


    public function findArray($array){

          $qb = $this->createQueryBuilder('b')
            ->select('b')
            ->where('b.id IN (:array)')
            ->setParameter('array', $array);
        return $qb->getQuery()->getResult();
    }

    public function findByBijous() {
          $qb = $this->createQueryBuilder('b');
          $qb->leftJoin('b.produits', 'p')
                  ->addSelect('p')
                  ->where('b.id = :id')
                  ->orderBy('b.id', 'DESC')

                  ;
            
          $qb->getQuery()->getResult();
    }

    public function findAllVisibleQuery(Recherche $search): Query
    {
        $query =  $this->findVisibleQuery() ;
          if($search->getReference()) {
               $query = $query->
               andWhere('op.reference  LIKE  :ref ')
               ->setParameter('ref',  $search->getReference());
          }
          if($search->getPrix()){
              $query = $query
              ->andWhere('op.prix < :prix ')
              ->setParameter('prix', $search->getPrix());
          }
          if($search->getTitle()){
              $query = $query
              ->andWhere('b.title  LIKE  :title')
              ->setParameter('title', $search->getTitle());
                
          }
       
       return  $query->getQuery();
          
    }

    public function findVisibleQuery()
    {
        return $this->createQueryBuilder('b')
                       ->join('b.option_bijou', 'op')
                      ->addSelect('op')
                      ->orderBy('b.title' , 'ASC')
                      ;
                  
    }

     public function findBijousByTitle($motcle)
    {

        $query = $this->createQueryBuilder('b')
            ->where('b.title like  :motcle')

            ->setParameter('motcle', '%' . $motcle . '%')
            ->orderBy('b.id', 'ASC')
            ->getQuery();

        return $query->getResult();
    }


}
