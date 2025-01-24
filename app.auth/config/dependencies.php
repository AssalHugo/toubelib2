<?php

use Psr\Container\ContainerInterface;
use toubeelib_auth\application\actions\SigninAction;
use toubeelib_auth\application\actions\ValidateAction;
use toubeelib_auth\core\provider\AuthProvider;
use toubeelib_auth\core\services\auth\AuthService;
use toubeelib_auth\core\repositoryInterfaces\PatientRepositoryInterface;
use toubeelib_auth\infrastructure\repositories\ArrayPatientRepository;

return [

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
    PatientRepositoryInterface::class => function (ContainerInterface $c) {
        return new ArrayPatientRepository($c->get('patient.pdo'));
    },
    ValidateAction::class => function (ContainerInterface $c) {
        return new ValidateAction($c->get('jwt.secret'));
    
    },

    'patient.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/patient.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },
];