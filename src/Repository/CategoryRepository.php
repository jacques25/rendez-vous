<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Boutique;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Mapping\OrderBy;
use PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use PhpParser\Node\Stmt\Return_;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findByArticle(Article $article)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.title = :title')
            ->setParameter('article', $article)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function  findArticleWithCategories()
    {
        $qb =  $this->createQueryBuilder('c');

        $qb->leftJoin('c.articles', 'a')
            ->select('c, a')
            ->where('c.title = :title')
            ->orderBy('c.id', 'ASC');

        return  $qb->getQuery()
            ->getResult();
    }

    public function findAllOrderByRang()
    {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.boutiques', 'bou')
            ->leftJoin('c.articles', 'a')
            ->LeftJoin('c.seances', 'sc')
            ->addSelect('a, bou, sc')
            ->orderBy('c.position', 'ASC');

        return  $qb->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
