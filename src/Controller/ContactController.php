<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Services\MailerService;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerService $mailer, ContactRepository $contactRepository)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contact = $form->getData();

            // $contactRepository->save($contact, true);

            // Email
            $email = (new Email())
                ->from('victor.weiss.be@gmail.com')
                ->to('jauge.goa@gmail.com')
                ->subject('test')
                ->text('gros texte')
                // ->html('<p>See Twig integration for better HTML integration!</p>')
            ;


            $mailer->sendEmail($email);
            $this->addFlash('success', 'Votre message a été envoyé');



            return $this->redirectToRoute('contact');
        } {

            return $this->render('contact/index.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
}
