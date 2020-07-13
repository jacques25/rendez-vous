<?php

namespace App\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Formation;
use App\Entity\Booking;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function getBookingsBeteween() {
          $sql = $this->createQueryBuilder('b');
          $sql ->select('b')
                  ->where('b.beginAt between b.beginAt->format("Y-m-d 00:00:00") and b.endAt->format("Y-m-d 23:59:59")')
                  ->orderBy('b.beginAt','ASC');
                  dd($sql);
        $sql->getQuery()->getResult();
          
    }

     public function getBooking($id) {
          $sql = $this->createQueryBuilder('b');
          $sql ->select('b')
                  ->where('b.id = :id')
                  ->setParameter('id', $id);
                 $sql ->getQuery() ->getResult();
     }

     public function getBookingsCount()
    {
        $qb =  $this->createQueryBuilder('b')
            ->leftJoin('b.seanceOption', 'so')
            ->addSelect('so')
            ->getQuery();
        return  (int)count($qb->getResult())  ;
    }

     public function findByFormation($formation) {
         $qb =  $this->createQueryBuilder('b');
         $qb->select('b') 
                ->InnerJoin('b.formation' , 'f')
                ->addSelect('f')
                ->leftJoin('b.users', 'u')
                ->addSelect('u')
                ->where('f.id = :formation')
                ->setParameter('formation', $formation);
  
       return      $qb->getQuery()
                ->getResult();
        
        } 

   

    // /**
    //  * @return Booking[] Returns an array of Booking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
