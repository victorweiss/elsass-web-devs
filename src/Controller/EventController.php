<?php

namespace App\Controller;

use App\Entity\Event;
use App\Services\EventService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    #[Route('/event', name: 'event')]
    public function index(EventService $eventService): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventService->getPaginatedEvents(),
        ]);
    }


    #[Route('/event/{slug}', name: 'event_show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
}
