<?php

namespace App\Controller;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends BaseController
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        $userStatus = $this->getUserStatus();
        $user = $this->getUser();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY', 'Access denied');
        if (!$user->isVerified('true')) {
            throw new AccessDeniedException('User is not verified');
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'userStatus' => $userStatus,
            'user' => $user
        ]);
    }
    #[Route('/deconnexion', name: 'logout', methods: ['GET'])]
    public function logout()
    {    }
}
