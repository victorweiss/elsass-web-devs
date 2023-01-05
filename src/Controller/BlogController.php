<?php

namespace App\Controller;


use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Services\ArticleService;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToHtml5LocalDateTimeTransformer;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog')]
    public function index(ArticleService $articleService, CategoryRepository $categoryRepo): Response
    {

        return $this->render('blog/index.html.twig', [
            'articles' => $articleService->getPaginatedArticles(),
            'categories' => $categoryRepo->findAll()
        ]);
    }

    #[Route('/blog/{slug}', name: 'article_show')]
    public function show(Article $article,ArticleService $articleService): Response
    {
        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'articles' => $articleService->getPaginatedArticles(),
        ]);
    }


    #[Route('/blog/category/{slug}', name: 'category_name', methods: ['GET'])]
    public function showCategory(Category $category, CategoryRepository $categoryRepo, ArticleService $articleService): Response
    {
        return $this->render('blog/category.html.twig', [
            'category' => $category,
            'articles' => $articleService->getPaginatedArticles(),
            'categoryArticles' => $articleService->getPaginatedArticlesByCategory($category),
            'categories' => $categoryRepo->findAll(),
        ]);
    }
}
