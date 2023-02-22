<?php

namespace App\Controller;

use App\Entity\EventBooking;
use App\Repository\EventBookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }


    #[Route('user/event-booking/{id}', name: 'event_booking_delete', methods: ['POST'])]
    public function delete(Request $request, EventBooking $eventBooking, EventBookingRepository $eventBookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventBooking->getId(), $request->request->get('_token'))) {
            $eventBookingRepository->remove($eventBooking, true);
        }

        return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
    }



}
