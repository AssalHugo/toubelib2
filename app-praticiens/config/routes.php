<?php
declare(strict_types=1);

use Slim\App;
use toubeelibPraticien\application\actions\ConsulterListePraticiensAction;
use toubeelibPraticien\application\actions\ConsulterPraticienAction;
use toubeelibPraticien\application\actions\SigninAction;

return function( App $app): App {

    $app->post('/auth/signin', SigninAction::class);

    $app->get('/praticiens/{ID-PRATICIEN}', ConsulterPraticienAction::class);

    $app->get('/praticiens', ConsulterListePraticiensAction::class);

    return $app;
};