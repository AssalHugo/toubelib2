<?php
declare(strict_types=1);

use Slim\App;
use toubeelib\application\actions\HomeAction;
use toubeelib\application\actions\SigninAction;

return function( App $app): App {

    $app->get('/', HomeAction::class);

    $app->post('/auth/signin', SigninAction::class);

    return $app;
};