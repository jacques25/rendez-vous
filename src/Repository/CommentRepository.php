<?php

namespace App\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Formation;
use App\Entity\Comment;
use App\Entity\Seance;

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

    public function getCommentsForFormation($formationId, $approved = true)
    {
        $qb = $this->createQueryBuilder('c')
         ->select('c')
         ->where('c.formation = :formation_id')
         ->addOrderBy('c.createdAt')
         ->setParameter('formation_id', $formationId);
        if (false === is_null($approved)) {
            $qb->andWhere('c.approved = :approved')
              ->setParameter('approved', $approved);
        }
        return $qb->getQuery()
         ->getResult();
    }

    public function getRatingCommentByFormation(Formation $formation)
    {
        return  $this->createQueryBuilder('c')
                        ->where('c.approved = true' )
                        ->andWhere('c.formation = :formation')
                         ->setParameter('formation', $formation)
                        ->innerJoin('c.formation', 'f')
                         ->select('SUM(c.rating) as  numberRatings, AVG(c.rating) as  averageRatings, f.slug')
                         ->getQuery()->getOneOrNullResult();
        ;
    }


    public function getRatingCommentBySeance(Seance $seance)
    {
        return  $this->createQueryBuilder('c')
                         ->where('c.approved = true' )
                        ->andWhere('c.seance = :seance')
                         ->setParameter('seance', $seance)
                        ->innerJoin('c.seance', 's')
                         ->select('SUM(c.rating) as  numberRatings, AVG(c.rating) as  averageRatings, s.slug')
                         ->getQuery()->getOneOrNullResult();
        ;
    }

    public function getNumberCommentBySeance(Seance $seance) {
           return $this->createQueryBuilder('c')
               ->where('c.approved = true' )
               ->andWhere('c.seance = :seance')
                         ->setParameter('seance', $seance)
                        ->innerJoin('c.seance', 's')
                        ->select('COUNT(c.id) as NumberComments, s.slug')
                        ->getQuery()->getOneOrNullResult();
    }

     public function getNumberCommentByFormation(Formation $formation) {
           return $this->createQueryBuilder('c')
                         ->where('c.approved = true' )
                          ->andWhere('c.formation = :formation')   
                     
                         ->setParameter('formation', $formation)
                        ->innerJoin('c.formation', 'f')
                        ->select('COUNT(c.id) as NumberComments, f.slug')
                       
                        ->getQuery()->getOneOrNullResult();
    }

    public function getRatingByComment() {
            return $this->createQueryBuilder('c')
                   ->where('c.approved = true')
                  ->orderBy('c.rating', 'ASC')
                  ->getQuery()->getResult();
    }
    
    public function findLastMessagesComment()
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(3);
            
      
        return  $qb->getQuery()
            ->getResult();
    }
      public function getCommentsCount()
    {
        return $this->createQueryBuilder('comment')
            ->select('COUNT(comment.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByPublication() {
          
           return $this->createQueryBuilder('c')
                
                  ->orderBy('c.createdAt', 'DESC')
                  ->getQuery()->getResult();
          
    }
}
