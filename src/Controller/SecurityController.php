<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/deconnexion', name: 'deconnexion', methods: ['GET'])]
    public function logout()
    {
    }
}
