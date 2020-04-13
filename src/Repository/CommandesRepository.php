<?php

namespace App\Repository;

use App\Entity\Commandes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
            ->getQuery()
            ->getSingleScalarResult();
    }


     public function findLastCommandes()
    {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.user', 'u')
            ->addSelect('u')
            ->orderBy('c.date_commande', 'DESC');
            
      
        return  $qb->getQuery()
            ->getResult();
    }
}
