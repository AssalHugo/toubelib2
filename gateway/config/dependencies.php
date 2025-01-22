<?php

use Gateway\Actions\GenericGetCatalogAction;
use Gateway\Actions\ListePraticiensAction;
use Gateway\Actions\PraticienAction;
use Gateway\Actions\SigninAction;
use Psr\Container\ContainerInterface;

$settings = require __DIR__ . '/settings.php';

return [

    'settings' => $settings,

    //On définit la dépendance guzzle
    'guzzle' => function(ContainerInterface $container) {
        return new GuzzleHttp\Client([
            'base_uri' => $container->get('toubeelib.api')
        ]);
    },

    //On définit la dépendance ListePraticiensAction
    ListePraticiensAction::class => function(ContainerInterface $container) {
        return new ListePraticiensAction($container->get('guzzle'));
    },

    PraticienAction::class => function(ContainerInterface $container) {
        return new PraticienAction($container->get('guzzle'));
    },

    GenericGetCatalogAction::class => function(ContainerInterface $container) {
        return new GenericGetCatalogAction($container->get('guzzle'));
    },
    SigninAction::class => function(ContainerInterface $container) {
        return new SigninAction($container->get('guzzle'));
    }
];