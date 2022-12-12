<?php

namespace App\Controller;


use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Services\ArticleService;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
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
    public function show(Article $article): Response
    {
        return $this->render('blog/show.html.twig', [
            'article' => $article,
        ]);
    }


    
    #[Route('/blog/category/{category}', name: 'article_category')]
    public function filter(ArticleService $articleService, Category $category, CategoryRepository $categoryRepo): Response
    {
        
        return $this->render('blog/category.html.twig', [
            // 'articles' => $articleService->getPaginatedArticles($category),
            'categories' => $categoryRepo->findAll()
        ]);
    }


}
