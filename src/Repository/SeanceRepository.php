<?php

namespace App\Repository;

use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Seance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seance[]    findAll()
 * @method Seance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seance::class);
    }

    public function getSeanceOptionWithSeance()
    {
        $sql = $this->createQueryBuilder('s');
        $sql->select('s')
                ->leftJoin('s.seanceOptions' , 'so')
                ->addSelect('so')
                ->leftJoin('so.bookings' ,'b')
                ->addSelect('b');
       $sql->getQuery()->getResult();
    }
}
