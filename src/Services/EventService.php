<?php

namespace App\Services;

use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class EventService
{
    public function __construct(
        private RequestStack $requestStack,
        private EventRepository $eventRepo,
        private PaginatorInterface $paginator,
    ) {}

    public function getPaginatedEvents()
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $eventsQuery = $this->eventRepo->paginateActiveEvent();

        return $this->paginator->paginate($eventsQuery, $page, $limit);
    }

    public function getPaginatePastEvent()
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $eventsQuery = $this->eventRepo->paginatePastEvent();

        return $this->paginator->paginate($eventsQuery, $page, $limit);
    }

}
