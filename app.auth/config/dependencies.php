<?php

use Psr\Container\ContainerInterface;
use toubeelib\application\actions\SigninAction;
use toubeelib\core\provider\AuthProvider;
use toubeelib\core\services\auth\AuthService;

return [

    'jwt.secret' => function () {
        $config = parse_ini_file(__DIR__ . '/toto.env');
        return $config['JWT_SECRET_KEY'];
    },

    'AuthProvider' => function (ContainerInterface $c) {
        return new AuthProvider($c->get(AuthService::class), $c->get('jwt.secret'));
    },

    SigninAction::class => function (ContainerInterface $c) {
        return new SigninAction($c->get('AuthProvider'));
    },
];