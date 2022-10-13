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
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerService $mailer, ContactRepository $contactRepository,  Recaptcha3Validator $recaptcha3Validator)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contactRepository->save($contact, true);
            $score = $recaptcha3Validator->getLastResponse()->getScore();

            // Email
            $email = (new Email())
                ->to($this->getParameter('email_contact'))
                ->subject($contact->getSubject())
                ->text($contact->getMessage())
                // ->html('<p>See Twig integration for better HTML integration!</p>')
            ;

            $mailer->sendEmail($email);
            $this->addFlash('success', 'Votre message a été envoyé');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
