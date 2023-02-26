<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\EventRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{
    public function __construct(
        private ArticleRepository $blogArticleRepository,
        private EventRepository $eventRepository,
        private LoggerInterface $logger,
    ) {}

    #[Route('/sitemap.xml', name: 'sitemap')]
    public function index()
    {
        $urls = [];

        $routes = [
            'home',
            'contact',
            'blog',
            'event',
        ];

        foreach ($routes as $route) {
            try {
                $urls[]['loc'] = $this->generateUrl($route, [], UrlGeneratorInterface::ABSOLUTE_URL);
            } catch (Exception $e) {
                $this->logger->error(sprintf("[%s l.%s] - %s", __CLASS__, __LINE__, $e->getMessage()));
            }
        }

        $articles = $this->blogArticleRepository->findBy(['marking' => 'Actif']);
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

        $events = $this->eventRepository->findAll();
        foreach ($events as $event) {
            $urls[] = [
                'loc' => $this->generateUrl(
                    'event_show',
                    ['slug' => $event->getSlug()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'lastmod' => $event->getUpdatedAt()->format('Y-m-d'),
            ];
        }


        $response = $this->render('sitemap/sitemap.html.twig', ['urls' => $urls]);
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
