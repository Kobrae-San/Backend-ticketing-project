<?php

$email = (new Email ())
    ->from ('paris.easytickets@gmail.com')
    ->to($email)
    ->subject('Welcome!')
    ->text($text);

$dsn = 'gmail+smtp://USERNAME:APP-PASSWORD@default';


$transport = Transport::fromDsn();

$mailer = new Mailer($transport);

$mailer->send($email);

?>