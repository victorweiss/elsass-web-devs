<?php

namespace App\Controller;

use App\Entity\User;
use App\Controller\BaseController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends BaseController
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
            'userStatus' => $this->getUserStatus()
        ]);
    }

    #[Route('/redirect', name: 'login_redirect')]
    public function dispatch(): Response
    {
        $user = $this->getUser();
        if (!$user->isVerified('true')) {
            throw new AccessDeniedException('User is not verified');
        } else {

            if ($this->isGranted("ROLE_ADMIN")) {
                return $this->render('admin/dashboard.html.twig', [
                    'userStatus' => $this->getUserStatus(),
                    'user' => $user
                ]);
            } elseif ($this->isGranted("ROLE_USER")) {
                return $this->render('user/index.html.twig', [
                    'userStatus' => $this->getUserStatus(),
                    'user' => $user
                ]);
            } else {
                return $this->render('home/index.html.twig', [
                    'userStatus' => $this->getUserStatus(),
                    'user' => $user
                ]);
            }
        }
    }

    #[Route('/deconnexion', name: 'logout', methods: ['GET'])]
    public function logout()
    {
    }
}
