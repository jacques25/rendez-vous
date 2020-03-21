<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }



    public function findPageByCategory($category)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p')
            ->innerJoin('p.category', 'c')
            ->Where('category.id = :category')
            ->setParameter('category', $category);


        return  $qb->getQuery()->getResult();
    }
}
