<?php

use Gateway\Actions\GenericGetCatalogAction;
use Gateway\Actions\ListePraticiensAction;
use Gateway\Actions\PraticienAction;
use Gateway\Actions\SigninAction;
use Psr\Container\ContainerInterface;
use Gateway\Actions\CreerRendezVousAction;
use Gateway\Actions\ConsulterRendezVousAction;
use Gateway\Actions\ModifierOuGererCycleRendezVousAction;
use Gateway\Actions\AnnulerRendezVousAction;



$settings = require __DIR__ . '/settings.php';

return [

    'settings' => $settings,

    //On définit la dépendance guzzle
    'guzzle' => function(ContainerInterface $container) {
        return new GuzzleHttp\Client([
            'base_uri' => $container->get('toubelib.api')
        ]);
    },
    'guzzle2' => function(ContainerInterface $container) {
        return new GuzzleHttp\Client([
            'base_uri' => $container->get('api.toubeelib-rdvs')
        ]);
    },

    'guzzle3' => function(ContainerInterface $container) {
        return new GuzzleHttp\Client([
            'base_uri' => $container->get('api.toubeelib-auth')
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

    CreerRendezVousAction::class => function(ContainerInterface $container) {
        return new CreerRendezVousAction($container->post('guzzle2'));
    },

    ConsulterRendezVousAction::class => function(ContainerInterface $container) {
        return new ConsulterRendezVousAction($container->get('guzzle2'));
    },

    ModifierOuGererCycleRendezVousAction::class => function(ContainerInterface $container) {
        return new ModifierOuGererCycleRendezVousAction($container->get('guzzle2'));
    },

    AnnulerRendezVousAction::class => function(ContainerInterface $container) {
        return new AnnulerRendezVousAction($container->get('guzzle2'));
    },

   
    SigninAction::class => function (ContainerInterface $container) {
        return new SigninAction($container->get('guzzle3'));
    },


];