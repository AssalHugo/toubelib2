<?php
require __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

$transport = Transport::fromDsn('smtp://mailcatcher:1025');
$mailer = new Mailer($transport);

$email = (new Email())
    ->from('noreply@toubeelib.com')
    ->to('test@example.com')
    ->subject('Test MailCatcher')
    ->text('Ceci est un test.');

try {
    $mailer->send($email);
    echo "E-mail envoyé avec succès!";
} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage();
}