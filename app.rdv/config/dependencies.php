<?php

use Psr\Container\ContainerInterface;
use toubeelibRdv\application\actions\ConsulterRendezVousAction;
use toubeelibRdv\application\actions\SigninAction;
use toubeelibRdv\core\provider\AuthProvider;
use toubeelibRdv\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelibRdv\core\repositoryInterfaces\RendezVousRepositoryInterface;
use toubeelibRdv\core\services\auth\AuthService;
use toubeelibRdv\core\services\praticien\PraticienServiceInterface;
use toubeelibRdv\core\services\rdv\ServiceRendezVous;
use toubeelibRdv\core\services\rdv\ServiceRendezVousInterface;
use toubeelibRdv\infrastructure\adaptateur\PraticienServiceAdaptateur;
use toubeelibRdv\infrastructure\repositories\ArrayRdvRepository;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

return [

    'rdv.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/rdv.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },

    'guzzlePraticiens' => function(ContainerInterface $container) {
        return new GuzzleHttp\Client([
            'base_uri' => $container->get('toubelibPraticien.api')
        ]);
    },

    'rabbitmq' => function(ContainerInterface $container){
        $exchange_name = 'testExanges';
        $queue_name = 'testqueues';
        $routing_key = 'routing';
        $connection = new AMQPStreamConnection('rabbitmq',5672, 'admin', 'admin');
        $channel = $connection->channel();
        $channel->exchange_declare($exchange_name, 'direct', false, true, false);
        $channel->queue_declare($queue_name, false, true, false, false);
        $channel->queue_bind($queue_name, $exchange_name, $routing_key);
    },


    ConsulterRendezVousAction::class => function (ContainerInterface $c) {
        return new ConsulterRendezVousAction($c->get(ServiceRendezVousInterface::class));
    },

    ServiceRendezVousInterface::class => function (ContainerInterface $c) {
        return new ServiceRendezVous($c->get(RendezVousRepositoryInterface::class) , $c->get(PraticienServiceInterface::class));
    },

    RendezVousRepositoryInterface::class => function (ContainerInterface $c) {
        return new ArrayRdvRepository($c->get('rdv.pdo'), $c->get('patient.pdo'), $c->get('praticien.pdo'));
    },

    PraticienServiceInterface::class => function (ContainerInterface $c) {
        return new PraticienServiceAdaptateur($c->get('guzzlePraticiens'));
    },

   

    'jwt.secret' => function () {
        $config = parse_ini_file(__DIR__ . '/toubeelib.env');
        return $config['JWT_SECRET_KEY'];
    },

    'AuthProvider' => function (ContainerInterface $c) {
        return new AuthProvider($c->get(AuthService::class), $c->get('jwt.secret'));
    },

    SigninAction::class => function (ContainerInterface $c) {
        return new SigninAction($c->get('AuthProvider'));
    },
];