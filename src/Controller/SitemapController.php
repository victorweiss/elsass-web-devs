<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{

    private $blogArticleRepository;

    public function __construct(ArticleRepository $blogArticleRepository)
    {
        $this->blogArticleRepository = $blogArticleRepository;
       
    }

    #[Route('/sitemap.xml', name: 'sitemap')]
    public function index()
    {
        // find published blog posts from db
        $articles = $this->blogArticleRepository->findBy(['marking' => 'Actif']);
        $urls = [];
       
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => $this->generateUrl(
                    'article',
                    ['slug' => $article->getSlug()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'lastmod' => $article->getUpdatedAt()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.5',
            ];
        }
        


        $response = new Response(
            $this->renderView('./sitemap/sitemap.html.twig', ['urls' => $urls]),
            200
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
