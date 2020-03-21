<?php

namespace App\Repository;

use App\Entity\OptionBijou;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method OptionBijou|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionBijou|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionBijou[]    findAll()
 * @method OptionBijou[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionBijouRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionBijou::class);
    }



    public function findArray($array)
    {
        $qb = $this->createQueryBuilder('ob')
            ->select('ob')
            ->where('ob.id IN (:array)')

            ->setParameter('array', $array);
        return $qb->getQuery()->getResult();
    }
}
