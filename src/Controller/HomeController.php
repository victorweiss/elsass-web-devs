<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HomeController extends AbstractController
{
    #[Route('', name: 'home')]
    public function index(EventRepository $eventRepository, NormalizerInterface $normalizer): Response
    {
        $events = $eventRepository->findAll();

        return $this->render(
            'home/index.html.twig',
            [
                'events' => $normalizer->normalize($events, null, [AbstractNormalizer::GROUPS => [Event::GROUP_CALENDAR] ])
            ]
        );
    }

    #[Route('test-ip', name: 'test_ip')]
    public function testIp(Request $request): Response
    {
        $ip = $request->getClientIp();

        return new Response($ip);
    }
}
