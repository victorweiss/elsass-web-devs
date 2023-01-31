<?php

namespace App\Controller;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LoginController extends BaseController
{
    #[Route('/connexion', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $userStatus = $this->getUserStatus();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'userStatus' => $userStatus
        ]);
    }

    #[Route('/redirect', name: 'login_redirect')]
    public function dispatch(): Response
    {
        $userStatus = $this->getUserStatus();
        $user = $this->getUser();

        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('admin/dashboard.html.twig', [
                'user' => $user,
                'userStatus' => $userStatus

            ]);
        } elseif ($this->isGranted("ROLE_USER")) {
            return $this->render('user/index.html.twig', [
                'user' => $user,
                'userStatus' => $userStatus

            ]);
        } else {
            return $this->render('home/index.html.twig', [
                'user' => $user,
                'userStatus' => $userStatus

            ]);
        }
    }
}
