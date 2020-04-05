<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Bijou;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
}
