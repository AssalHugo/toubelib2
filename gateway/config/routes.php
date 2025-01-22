<?php

use Gateway\Actions\ExampleAction;
use Gateway\Actions\GenericGetCatalogAction;
use Gateway\Actions\ListePraticiensAction;
use Gateway\Actions\PraticienAction;
use Gateway\Actions\SigninAction;
use Slim\App;
use Gateway\middlewares\AddHeaders;


return function (App $app): App {

    $app->get('/', ExampleAction::class);

    // Exemple d'une autre route
    $app->get('/hello', function ($request, $response) {
        $response->getBody()->write("Hello, World!");
        return $response;
    });

    $app->get('/praticiens', ListePraticiensAction::class)
        ->add(new AddHeaders);

    $app->get('/praticiens/{id}',  PraticienAction::class)
        ->add(new AddHeaders);

    $app->get('/praticiens/{id}/planning', GenericGetCatalogAction::class)
        ->add(new AddHeaders);
    
    $app->post('/auth/signin', SigninAction::class)
        ->add(new AddHeaders);


    $app->post('/rdvs', GenericGetCatalogAction::class);

    $app->get('/rdvs/{ID-RDV}', GenericGetCatalogAction::class);

    $app->patch('/rdvs/{ID-RDV}', GenericGetCatalogAction::class);

    $app->delete('/rdvs/{ID-RDV}', GenericGetCatalogAction::class);

    $app->get('/patients/{ID-PATIENT}/rdvs', GenericGetCatalogAction::class);

    $app->post('/auth/signin', GenericGetCatalogAction::class);

    return $app;
};
