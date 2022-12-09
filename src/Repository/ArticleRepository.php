<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query;
use Doctrine\ORM\Query as ORMQuery;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function findForPagination(?Category $category = null): ORMQuery
    {
        $qb = $this->createQueryBuilder('a')
        ->orderBy('a.createdAt', 'DESC')
        // ->where('a.marking = Actif')
        ;
        // ->where($qb->expr()->eq('a.marking',':articleMarking'))
        // ->setParameter('', )

        if($category) {
            $qb->leftJoin('a.categories', 'c')
            ->where($qb->expr()->eq('c.id',':categoryId'))
            ->setParameter('categoryId',$category->getId());
        }
        return $qb->getQuery();
        

    }





    
// 	private function getArticleQueryBuilder(){
// 		$queryBuilder = $this->createQueryBuilder('a')
//             // ->where('a.marking = Actif')
// 			->orderBy('a.createdAt', 'DESC')
//             ;

// 		return $queryBuilder;
// 	}

//    public function getPaginatedArticles(){
//        $queryBuilder = $this->getArticleQueryBuilder();
//        $query = $queryBuilder->getQuery();
//        $paginator = new Paginator($query, true);

//        return $paginator;
//    }
  





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
