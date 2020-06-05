<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

     public function getCommentsForSeance($seanceId, $approved = true)
    {
        $qb = $this->createQueryBuilder('c')
                   ->select('c')
                   ->where('c.seance = :seance_id')
                   ->addOrderBy('c.createdAt')
                   ->setParameter('seance_id', $seanceId);

        if (false === is_null($approved)) {
            $qb->andWhere('c.approved = :approved')
               ->setParameter('approved', $approved);
        }

        return $qb->getQuery()
                  ->getResult();
    }
}
