<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected function getUserStatus()
    {
        $user = $this->getUser();
        if ($user) {
            if ($user->isVerified('true')) {
                return 'authenticated';
            } else {
                return 'unauthenticated';
            }
        }
    }
}
