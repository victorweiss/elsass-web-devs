<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\MailerService;
use Symfony\Component\Mime\Email;
use App\Repository\ContactRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerService $mailer, ContactRepository $contactRepository, Recaptcha3Validator $recaptcha3Validator)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contactRepository->save($contact, true);
            $score = $recaptcha3Validator->getLastResponse()->getScore();

            $email = (new TemplatedEmail())
                ->to($this->getParameter('email_contact'))
                ->subject($contact->getSubject())
                ->text($contact->getMessage())
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'contact' => $contact
                ]);

            $mailer->sendEmail($email);
            $this->addFlash('success', 'Votre message a été envoyé');
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
