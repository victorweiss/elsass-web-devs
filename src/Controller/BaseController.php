<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected function getUserStatus()
    {
        if ($this->isGranted('ROLE_USER')) {
            return 'authenticated';
        } else {
            return 'unauthenticated';
        }
    }
}