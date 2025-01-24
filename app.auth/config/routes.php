<?php
declare(strict_types=1);

use Slim\App;
use toubeelib_auth\application\actions\HomeAction;
use toubeelib_auth\application\actions\SigninAction;
use toubeelib_auth\application\actions\ValidateAction;


return function( App $app): App {

    $app->get('/', HomeAction::class);

    $app->post('/auth/signin', SigninAction::class);

    $app->post('/auth/validate', ValidateAction::class);

    return $app;
};