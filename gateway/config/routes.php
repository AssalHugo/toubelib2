<?php

use Gateway\Actions\ExampleAction;
use Gateway\Actions\GenericGetCatalogAction;
use Gateway\Actions\ListePraticiensAction;
use Gateway\Actions\PraticienAction;
use Slim\App;
use Gateway\middlewares\AddHeaders;


return function (App $app): App {

    $app->get('/', ExampleAction::class);

    // Exemple d'une autre route
    $app->get('/hello', function ($request, $response) {
        $response->getBody()->write("Hello, World!");
        return $response;
    });

    $app->get('/praticiens', GenericGetCatalogAction::class)
        ->add(new AddHeaders);

    $app->get('/praticiens/{id}', GenericGetCatalogAction::class)
        ->add(new AddHeaders);

    $app->get('/praticiens/{id}/planning', GenericGetCatalogAction::class)
        ->add(new AddHeaders);

    $app->post('/rdvs', GenericGetCatalogAction::class);

    $app->get('/rdvs/{ID-RDV}', GenericGetCatalogAction::class);

    $app->patch('/rdvs/{ID-RDV}', GenericGetCatalogAction::class);

    $app->delete('/rdvs/{ID-RDV}', GenericGetCatalogAction::class);

    $app->get('/patients/{ID-PATIENT}/rdvs', GenericGetCatalogAction::class);

    return $app;
};
