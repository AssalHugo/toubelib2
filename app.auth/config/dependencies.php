<?php

use Psr\Container\ContainerInterface;
use toubeelib_auth\application\actions\SigninAction;
use toubeelib_auth\core\provider\AuthProvider;
use toubeelib_auth\core\services\auth\AuthService;

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
];