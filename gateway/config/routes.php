<?php

use Gateway\Actions\ConsulterRendezVousAction;
use Gateway\Actions\CreerRendezVousAction;
use Gateway\Actions\ExampleAction;
use Gateway\Actions\GenericGetCatalogAction;
use Gateway\Actions\ListePraticiensAction;
use Gateway\Actions\ListerDispoPraticienAction;
use Gateway\Actions\PraticienAction;
use Slim\App;
use Gateway\middlewares\AddHeaders;
use Gateway\Actions\GenericGetCatalogAction00;
use Gateway\middlewares\AuthnMiddleware;
use Gateway\Actions\GenericGetCatalogAction01;

return function (App $app): App {

    $app->add(AddHeaders::class); 

    $app->group('', function ($app) {
        $app->get('/praticiens/{id}', PraticienAction::class);
        $app->get('/praticiens/{id}/planning', GenericGetCatalogAction::class);
        $app->post('/rdvs', GenericGetCatalogAction01::class);
        $app->get('/rdvs/{ID-RDV}', GenericGetCatalogAction01::class);
        $app->get('/praticiens/{ID-PRATICIEN}/disponibilites', ListerDispoPraticienAction::class);
    })->add(AuthnMiddleware::class); 

    $app->post('/auth/signin', GenericGetCatalogAction00::class); 
    $app->post('/auth/validate', GenericGetCatalogAction00::class); 

    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    })->add(AddHeaders::class);
        


    return $app;
};
