<?php

use Gateway\Actions\ListePraticiensAction;
use Psr\Container\ContainerInterface;

$settings = require __DIR__ . '/settings.php';

return [

    'settings' => $settings,

    //On définit la dépendance guzzle
    'guzzle' => function(ContainerInterface $container) {
        return new GuzzleHttp\Client([
            'base_uri' => $container->get('settings')['toubelib.api']
        ]);
    },

    //On définit la dépendance ListePraticiensAction
    ListePraticiensAction::class => function(ContainerInterface $container) {
        return new ListePraticiensAction($container->get('guzzle'));
    },
];