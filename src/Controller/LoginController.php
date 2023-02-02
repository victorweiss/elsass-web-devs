<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

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
        $user = $this->getUser();

        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('admin/dashboard.html.twig', [
                'user' => $user,

            ]);
        } elseif ($this->isGranted("ROLE_USER")) {
            return $this->render('user/index.html.twig', [
                'user' => $user,

            ]);
        } else {
            return $this->render('home/index.html.twig', [
                'user' => $user,

            ]);
        }
    }
}
