<?php

use Gateway\Actions\ExampleAction;
use Gateway\Actions\ListePraticiensAction;
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

    return $app;
};
