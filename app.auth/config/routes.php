<?php
declare(strict_types=1);

use Slim\App;
use toubeelib_auth\application\actions\HomeAction;
use toubeelib_auth\application\actions\SigninAction;

return function( App $app): App {

    $app->get('/', HomeAction::class);

    $app->post('/auth/signin', SigninAction::class);

    return $app;
};