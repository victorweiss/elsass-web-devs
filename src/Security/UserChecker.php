<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if ($user->isBlocked('true')){
            throw new CustomUserMessageAuthenticationException('Utilisateur bloqué. Raus !');
        }
        elseif (!$user->isVerified('true')) {
            throw new CustomUserMessageAuthenticationException('Utilisateur non vérifié, regardez voitre boîte mail');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
    }
}