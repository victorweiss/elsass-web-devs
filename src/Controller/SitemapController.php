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
        $articles = $this->blogArticleRepository->findBy(['marking' => 'Actif']);
        $urls = [];

        $urls[] = ['loc' =>'https://www.elsass-web-devs.fr'];
        $urls[] = ['loc' =>'https://www.elsass-web-devs.fr/contact'];
        $urls[] = ['loc' =>'https://www.elsass-web-devs.fr/blog'];


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
