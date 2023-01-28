<?php

namespace App\Controller;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends BaseController
{
    #[Route('', name: 'home')]
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig',
            [
                'userStatus' => $this->getUserStatus()
            ]
        );
    }
}
