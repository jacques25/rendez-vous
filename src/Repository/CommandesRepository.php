<?php

namespace App\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\User;
use App\Entity\Commandes;
use Doctrine\ORM\Query;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commandes::class);
    }

   public function byFacture($user)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.user = :user')
            ->andWhere('c.valider = 1')
            ->andWhere('c.numero_commande != 0')
            ->orderBy('c.id')
            ->setParameter('user', $user);

        return $qb->getQuery()->getResult();
    }

    public function getCommandesCount()
    {
        return $this->createQueryBuilder('commandes')
            ->select('COUNT(commandes.id)')
            ->orderBy('commandes.date_commande', 'ASC')
            ->getQuery()
            ->getSingleScalarResult();
    }


     public function findLastCommandes()
    {
           $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.user', 'u')
            ->addSelect('u')
            ->orderBy('c.date_commande', 'DESC')
            ->setMaxResults(3);
            
      
        return  $qb->getQuery()
            ->getResult();
    }

    public function findCommandesByUser($user)
    {
       return $this->createQueryBuilder('c')
              ->leftJoin('c.user', 'u')
              ->addSelect('u')
              ->where('u.id = :user')
              ->setParameter('user', $user)
              ->getQuery()
              ->getResult();
             
    }
   
    public function findAllVisibleQuery()
    {
        return $this->createQueryBuilder('c')
                       ->select('c')
                      ->getQuery()
                      ->getResult();
          
    }
}
