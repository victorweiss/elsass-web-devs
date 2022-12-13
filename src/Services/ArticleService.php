<?php

namespace App\Services;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ArticleService
{
    public function __construct(
private RequestStack $requestStack,
private ArticleRepository $articleRepo,
private PaginatorInterface $paginator,

    )    {
        
    }

    public function getPaginatedArticles()
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $articlesQuery = $this->articleRepo->findForPagination();

        return $this->paginator->paginate($articlesQuery, $page, $limit);
    }


    public function getPaginatedArticlesByCategory(?Category $category = null)
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $articlesQuery = $this->articleRepo->paginateByCategory($category);

        return $this->paginator->paginate($articlesQuery, $page, $limit);
    }

}