<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventBooking;
use App\Form\EventBookingType;
use App\Services\EventService;
use App\Services\MailerService;
use Symfony\Component\Mime\Address;
use App\Repository\EventBookingRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    #[Route('/evenement', name: 'event')]
    public function index(EventService $eventService): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventService->getPaginatedEvents(),
            'pastEvents' => $eventService->getPaginatePastEvent(),
        ]);
    }

    #[Route('/evenement/{slug}', name: 'event_show')]
    public function show(Event $event, EventBookingRepository $eventBookingRepository, Request $request, MailerService $mailer): Response
    {
        $booking = new EventBooking;
        $bookingForm = $this->createForm(EventBookingType::class, $booking);
        $bookingForm->handleRequest($request);

        if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {

            if (!$this->isGranted('ROLE_USER')) {
                return $this->redirectToRoute('register');
            } else {

                $user = $this->getUser();
                $existingBooking = $eventBookingRepository->findOneBy(['user' => $user, 'event' => $event]);
                if ($existingBooking) {
                    $this->addFlash('warning', 'Vous êtes déjà inscrit pour cet événement');
                    return $this->render('event/show.html.twig', [
                        'bookingForm' => $bookingForm->createView(),
                        'event' => $event,
                        'slug' => $event->getSlug(),
                    ]);
                }
                $booking->setUser($user);
                $booking->setEvent($event);

                $eventBookingRepository->save($booking, true);

                $email = (new TemplatedEmail())
                    ->from(new Address($this->getParameter('email_contact'), 'Elsass Web Devs'))
                    ->to(new Address($user->getEmail(), $user->getLastName() . ' ' . $user->getFirstName()))
                    ->subject('Confirmation inscription événement')
                    ->htmlTemplate('emails/booking_confirmation.html.twig')
                    ->context([
                        'firstName' => $user->getFirstName(),
                        'title' => $event->getTitle(),
                        'slug' => $event->getSlug(),
                        'startAt' => $event->getStartAt()->format('d-m-Y')
                    ]);

                $mailer->sendEmail($email);


                $this->addFlash('success', 'Votre inscription a bien été enregistrée et un email de confirmation vous a été envoyé');
            }
        }
        return $this->render('event/show.html.twig', [
            'bookingForm' => $bookingForm->createView(),
            'event' => $event,
            'slug' => $event->getSlug(),
        ]);
    }
}
