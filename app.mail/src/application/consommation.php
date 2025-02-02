<?php

namespace appMail\application;


require __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use appMail\application\MailService;

// Configuration codée en dur pour RabbitMQ (identique au service RDV)
$connection = new AMQPStreamConnection(
    'rabbitmq', 
    5672,       
    'admin',    
    'admin'     
);

$channel = $connection->channel();

$channel->exchange_declare('rdvs', 'direct', false, true, false);
$channel->queue_declare('rdv_notifications', false, true, false, false);
$channel->queue_bind('rdv_notifications', 'rdvs', 'rdv.cree'); 

$transport = Transport::fromDsn('smtp://mailcatcher:1025');
$mailer = new Mailer($transport);
$mailService = new MailService($mailer);

echo " [*] En attente de messages sur rdv_notifications. Pour quitter: CTRL+C\n";

$callback = function (AMQPMessage $msg) use ($mailService) {
    try {
        $data = json_decode($msg->body, true);
        
        if (!$data || !isset($data['email'])) {
            throw new \Exception('Message JSON invalide ou email manquant');
        }

        echo " [x] Notification RDV reçue\n";
        
        // Envoi du mail
        $mailService->sendEmail(
            $data['email'],
            'Nouveau rendez-vous Toubeelib',
            sprintf("Votre rendez-vous du %s avec le Dr %s est confirmé.", 
                $data['creneau'] ?? 'date inconnue',
                $data['praticien'] ?? 'praticien inconnu'
            )
        );
        
        echo " [x] Mail envoyé à {$data['email']}\n";
        
    } catch (\Exception $e) {
        echo " [x] ERREUR: " . $e->getMessage() . "\n";
    } finally {
        $msg->ack();
    }
};

$channel->basic_consume(
    'rdv_notifications', 
    '', 
    false, 
    false, 
    false, 
    false, 
    $callback
);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();