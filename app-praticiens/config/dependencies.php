<?php

use Psr\Container\ContainerInterface;
use toubeelibPraticien\application\actions\SigninAction;
use toubeelibPraticien\core\provider\AuthProvider;
use toubeelibPraticien\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelibPraticien\core\services\auth\AuthService;
use toubeelibPraticien\core\services\praticien\ServicePraticienInterface;
use toubeelibPraticien\core\services\praticien\ServicePraticien;
use toubeelibPraticien\infrastructure\repositories\ArrayPraticienRepository;

return [

    'praticien.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/praticien.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new ArrayPraticienRepository($c->get('praticien.pdo'));
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