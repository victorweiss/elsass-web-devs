<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/redirect', name: 'login_redirect')]
    public function dispatch(): Response
    {
        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->redirectToRoute('admin');
        } elseif ($this->isGranted("ROLE_USER")) {
            return $this->redirectToRoute('user');
        } else {
            return $this->redirectToRoute('home');
        }
    }

    #[Route('/deconnexion', name: 'logout', methods: ['GET'])]
    public function logout()
    {

    }
}
