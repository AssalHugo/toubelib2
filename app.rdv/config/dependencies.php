<?php

use Psr\Container\ContainerInterface;
use toubeelib_rdv\application\actions\ConsulterRendezVousAction;
use toubeelib_rdv\application\actions\SigninAction;
use toubeelib_rdv\core\provider\AuthProvider;
use toubeelib_rdv\core\repositoryInterfaces\PatientRepositoryInterface;
use toubeelib_rdv\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib_rdv\core\repositoryInterfaces\RendezVousRepositoryInterface;
use toubeelib_rdv\core\services\auth\AuthService;
use toubeelib_rdv\core\services\praticien\ServicePraticienInterface;
use toubeelib_rdv\core\services\praticien\ServicePraticien;
use toubeelib_rdv\core\services\rdv\ServiceRendezVous;
use toubeelib_rdv\core\services\rdv\ServiceRendezVousInterface;
use toubeelib_rdv\infrastructure\repositories\ArrayPatientRepository;
use toubeelib_rdv\infrastructure\repositories\ArrayPraticienRepository;
use toubeelib_rdv\infrastructure\repositories\ArrayRdvRepository;

return [



    'rdv.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/rdv.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },

    'patient.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/patient.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },

    
    'praticien.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/praticien.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },


    ConsulterRendezVousAction::class => function (ContainerInterface $c) {
        return new ConsulterRendezVousAction($c->get(ServiceRendezVousInterface::class));
    },

    ServiceRendezVousInterface::class => function (ContainerInterface $c) {
        return new ServiceRendezVous($c->get(RendezVousRepositoryInterface::class) , $c->get(PraticienRepositoryInterface::class));
    },

    RendezVousRepositoryInterface::class => function (ContainerInterface $c) {
        return new ArrayRdvRepository($c->get('rdv.pdo'), $c->get('patient.pdo'), $c->get('praticien.pdo'));
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