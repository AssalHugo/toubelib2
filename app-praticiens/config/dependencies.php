<?php

use Psr\Container\ContainerInterface;
use toubeelibPraticien\application\actions\ConsulterRendezVousAction;
use toubeelibPraticien\application\actions\SigninAction;
use toubeelibPraticien\core\provider\AuthProvider;
use toubeelibPraticien\core\repositoryInterfaces\PatientRepositoryInterface;
use toubeelibPraticien\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelibPraticien\core\repositoryInterfaces\RendezVousRepositoryInterface;
use toubeelibPraticien\core\services\auth\AuthService;
use toubeelibPraticien\core\services\praticien\ServicePraticienInterface;
use toubeelibPraticien\core\services\praticien\ServicePraticien;
use toubeelibPraticien\core\services\rdv\ServiceRendezVous;
use toubeelibPraticien\core\services\rdv\ServiceRendezVousInterface;
use toubeelibPraticien\infrastructure\repositories\ArrayPatientRepository;
use toubeelibPraticien\infrastructure\repositories\ArrayPraticienRepository;
use toubeelibPraticien\infrastructure\repositories\ArrayRdvRepository;

return [

    'praticien.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/praticien.db.ini');
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

    'rdv.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/rdv.db.ini');
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

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new ArrayPraticienRepository($c->get('praticien.pdo'));
    },

    PatientRepositoryInterface::class => function (ContainerInterface $c) {
        return new ArrayPatientRepository($c->get('patient.pdo'));
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