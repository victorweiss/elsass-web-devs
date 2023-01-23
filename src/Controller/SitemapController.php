<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{
    public function __construct(
        private ArticleRepository $blogArticleRepository,
        private LoggerInterface $logger,
    ) {}

    #[Route('/sitemap.xml', name: 'sitemap')]
    public function index()
    {
        $articles = $this->blogArticleRepository->findBy(['marking' => 'Actif']);
        $urls = [];

        $routes = [
            'home',
            'contact',
            'blog'
        ];

        foreach ($routes as $route) {
            try {
                $urls[] = $this->generateUrl($route, [], UrlGeneratorInterface::ABSOLUTE_URL);
            } catch (Exception $e) {
                $this->logger->error(sprintf("[%s l.%s] - %s", __CLASS__, __LINE__, $e->getMessage()));
            }
        }


        foreach ($articles as $article) {
            $urls[] = [
                'loc' => $this->generateUrl(
                    'article_show',
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
