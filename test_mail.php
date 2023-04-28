<?php
// use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\Mime\Email;
// use Symfony\Component\Mailer;



// function sendEmail(MailerInterface $mailer, string $from, string $to, string $subject, string $content): void
// {
//     $email = (new Email())
//         ->from($from)
//         ->to($to)
//         ->subject($subject)
//         ->html($content);

//     $mailer->send($email);
// }

// $transport = Transport::fromDsn('smtp://paris.easytickets@gmail.com:lucas_Admin@gmail.com');

// $mailer = new Mailer($transport);
// sendEmail($mailer, 'me@example.com', 'you@example.com', 'Test email', '<p>Hello world!</p>');

// <?php

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mime\Email;

function sendEmail(MailerInterface $mailer, string $from, string $to, string $subject, string $content): void
{
    $email = (new Email())
        ->from($from)
        ->to($to)
        ->subject($subject)
        ->html($content);

    $mailer->send($email);
}

$transport = new SmtpTransport('smtp.gmail.com', 587, 'tls');
$transport->setUsername('paris.easytickets@gmail.com');
$transport->setPassword('lucas_Admin@gmail.com');

$mailer = new Mailer($transport);
sendEmail($mailer, 'paris.easytickets@gmail.com', 'destination@example.com', 'Test email', '<p>Hello world!</p>');


?>