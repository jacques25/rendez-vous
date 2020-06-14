<?php

namespace App\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\User;
use App\Entity\Formation;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }


    public function loadUserByUsername($usernameOrEmail)
    {
        return $this->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.username = :query
                OR u.email = :query'
        )
            ->setParameter('query', $usernameOrEmail)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByEmail($email): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByActive($enable)
    {
        return $this->createQueryBuilder('u')
            ->where('u.is_enabled = :enable')
            ->setParameter('enable', $enable)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
     * @return User[]
     */
    public function findAllSubscribedToNewsletter(): array
    {
        return $this->createQueryBuilder('u')
        ->andWhere('u.subscribedToNewsletter = 1')
        ->getQuery()
        ->getResult();
    }

    public function findUserHasCommand()
    {
        return $this->createQueryBuilder('u')
               ->join('u.commandes' , 'c')
               ->addSelect('c')
               ->andWhere('c.sendCommande = 1')
               ->getQuery()
               ->getResult();
    }

   public  function findUserByFormation($id){
            
     $sql = $this->createQueryBuilder('u');
      $sql ->select('u')
                ->leftJoin('u.formations', 'f')
                ->addSelect('f')
                ->where('f.id = :id')
                ->setParameter('id' , $id)
                ;
           
           $sql->getQuery() ->getResult();
   }

   public function findWithSeanceAndSeanceOption()
   {
        $sql = $this->createQueryBuilder('u')
                 ->select('u')
                 ->leftJoin('u.seances','s')
                 ->addSelect('s')
                 ->leftJoin('u.seanceOptions', 'so')
                 ->addSelect('so')
                 ->getQuery()
                 ->getResult();
   }
}
