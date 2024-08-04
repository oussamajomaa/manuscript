<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer 
{
    private $mailer;


    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    // public function sendEmail(string $from, string $to, string $subject, string $text)
    public function sendEmail(string $from, string $to, string $subject, string $text)
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->text($text)
            ;

        $this->mailer->send($email);


    }
}
