<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        private string $emailContact
    ) {}

    public function sendEmail(Email $email): void
    {
        $email->from($this->emailContact);
        $this->mailer->send($email);
    }
}
