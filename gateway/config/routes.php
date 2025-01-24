<?php

use Gateway\Actions\ConsulterRendezVousAction;
use Gateway\Actions\CreerRendezVousAction;
use Gateway\Actions\ExampleAction;
use Gateway\Actions\GenericGetCatalogAction;
use Gateway\Actions\ListePraticiensAction;
use Gateway\Actions\ListerDispoPraticienAction;
use Gateway\Actions\PraticienAction;
use Gateway\Actions\SigninAction;
use Slim\App;
use Gateway\middlewares\AddHeaders;


return function (App $app): App {

    $app->get('/', ExampleAction::class);

    $app->get('/praticiens', ListePraticiensAction::class);

    $app->get('/praticiens/{id}',  PraticienAction::class);

    $app->get('/praticiens/{id}/planning', GenericGetCatalogAction::class)
        ->add(new AddHeaders);

    $app->post('/auth/signin', SigninAction::class)
        ->add(new AddHeaders);

    $app->get('/praticiens/{id}/planning', GenericGetCatalogAction::class);

    $app->post('/rdvs', CreerRendezVousAction::class);

    $app->get('/rdvs/{ID-RDV}', ConsulterRendezVousAction::class);


    $app->get('/praticiens/{ID-PRATICIEN}/disponibilites', ListerDispoPraticienAction::class);

    $app->post('/auth/signin', GenericGetCatalogAction::class);

    return $app;
};
