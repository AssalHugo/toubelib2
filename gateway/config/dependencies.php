<?php

use Gateway\Actions\GenericGetCatalogAction;
use Gateway\Actions\ListePraticiensAction;
use Gateway\Actions\PraticienAction;
use Psr\Container\ContainerInterface;

$settings = require __DIR__ . '/settings.php';

return [

    'settings' => $settings,

    //On définit la dépendance guzzle
    'guzzle' => function(ContainerInterface $container) {
        return new GuzzleHttp\Client([
            'base_uri' => $container->get('toubelib.api')
        ]);
    },

    'guzzlePraticiens' => function(ContainerInterface $container) {
        return new GuzzleHttp\Client([
            'base_uri' => $container->get('toubelibPraticien.api')
        ]);
    },

    //On définit la dépendance ListePraticiensAction
    ListePraticiensAction::class => function(ContainerInterface $container) {
        return new GenericGetCatalogAction($container->get('guzzlePraticiens'));
    },

    PraticienAction::class => function(ContainerInterface $container) {
        return new GenericGetCatalogAction($container->get('guzzlePraticiens'));
    },

    GenericGetCatalogAction::class => function(ContainerInterface $container) {
        return new GenericGetCatalogAction($container->get('guzzle'));
    }

];