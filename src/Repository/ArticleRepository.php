<?php

namespace App\Repository;

use App\Entity\Tag;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function getPublicQueryBuilder()
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.marking = :marking')
            ->setParameter('marking', 'Actif');
        return $qb;
    }

    public function paginateActiveArticle(): Query
    {
        $qb = $this->getPublicQueryBuilder();
        $qb->orderBy('a.createdAt', 'DESC');

        return $qb->getQuery();
    }

    public function getTopArticles(): array
    {
        $qb = $this->getPublicQueryBuilder();

        $qb ->orderBy('a.countViews', 'DESC')
            ->setMaxResults(3);

        return $qb->getQuery()->getResult();
    }

    public function paginateByCategory(Category $category): Query
    {
        $qb = $this->getPublicQueryBuilder();

        if ($category) {
            $qb ->orderBy('a.createdAt', 'DESC')
                ->leftJoin('a.category', 'c')
                ->andWhere('a.category = :category')
                ->setParameter('category', $category);
        }
        return $qb->getQuery();
    }

    public function paginateByTag(Tag $tag): Query
    {
        $qb = $this->getPublicQueryBuilder();

        if (!empty($tag)) {
            $qb ->orderBy('a.createdAt', 'DESC')
                ->leftJoin('a.tags', 't')
                ->andWhere('t.id IN (:tags)')
                ->setParameter('tags', $tag);
        }
        return $qb->getQuery();
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
