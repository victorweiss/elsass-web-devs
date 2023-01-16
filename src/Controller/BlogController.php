<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Article;
use App\Entity\Category;
use App\Services\ArticleService;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog')]
    public function index(ArticleService $articleService, CategoryRepository $categoryRepo): Response
    {
        return $this->render('blog/index.html.twig', [
            'articles' => $articleService->getPaginatedArticles(),
            'categories' => $categoryRepo->findAll(),
            'bestArticles' => $articleService->getTopArticles()
        ]);
    }

    #[Route('/blog/{slug}', name: 'article_show')]
    public function show(Article $article, ArticleService $articleService, ArticleRepository $articleRepository): Response
    {
        $article->setCountViews($article->getCountViews() + 1);
        $articleRepository->save($article, true);

        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'articles' => $articleService->getPaginatedArticles(),
            'bestArticles' => $articleService->getTopArticles()
        ]);
    }


    #[Route('/blog/category/{slug}', name: 'category_index', methods: ['GET'])]
    public function showCategory(Category $category, CategoryRepository $categoryRepo, ArticleService $articleService): Response
    {
        return $this->render('blog/index.html.twig', [
            'category' => $category,
            'articles' => $articleService->getPaginatedArticlesByCategory($category),
            'categories' => $categoryRepo->findAll(),
            'bestArticles' => $articleService->getTopArticles()
        ]);
    }


    #[Route('/blog/tag/{slug}', name: 'tag_index', methods: ['GET'])]
    public function showTag(Tag $tag, CategoryRepository $categoryRepo, ArticleService $articleService): Response
    {
        return $this->render('blog/index.html.twig', [
            'tag' => $tag,
            'articles' => $articleService->getPaginatedArticlesByTag($tag),
            'categories' => $categoryRepo->findAll(),
            'bestArticles' => $articleService->getTopArticles()
        ]);
    }
}
