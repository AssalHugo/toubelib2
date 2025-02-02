<?php

namespace appMail\application;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        
    }

    public function sendEmail(string $to, string $subject, string $text): void
    {
        $email = (new Email())
            ->from('noreply@toubeelib.com')
            ->to($to)
            ->subject($subject)
            ->text($text);

        $this->mailer->send($email);
    }
}