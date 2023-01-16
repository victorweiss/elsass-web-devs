<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{
    public function __construct(
        private ArticleRepository $blogArticleRepository
    ) {}

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
            ];
        }

        $response = $this->render('sitemap/sitemap.html.twig', ['urls' => $urls]);
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
