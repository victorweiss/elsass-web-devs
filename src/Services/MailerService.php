<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private MailerInterface $mailer
    ) {}

    public function sendEmail(Email $email): void
    {
        $this->mailer->send($email);
    }
}
