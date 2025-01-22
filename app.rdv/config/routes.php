<?php
declare(strict_types=1);

use Slim\App;
use toubeelibRdv\application\actions\ListerRendezVousPatientAction;
use toubeelibRdv\application\actions\ModifierOuGererCycleRendezVousAction;
use toubeelibRdv\application\actions\AnnulerRendezVousAction;
use toubeelibRdv\application\actions\ConsulterRendezVousAction;
use toubeelibRdv\application\actions\CreerRendezVousAction;
use toubeelibRdv\application\actions\HomeAction;
use toubeelibRdv\application\actions\SigninAction;

return function( App $app): App {

    $app->get('/', HomeAction::class);

    $app->post('/auth/signin', SigninAction::class);

    $app->post('/rdvs', CreerRendezVousAction::class);

    $app->get('/rdvs/{ID-RDV}', ConsulterRendezVousAction::class);

    $app->patch('/rdvs/{ID-RDV}', ModifierOuGererCycleRendezVousAction::class);

    $app->delete('/rdvs/{ID-RDV}', AnnulerRendezVousAction::class);

    $app->get('/patients/{ID-PATIENT}/rdvs', ListerRendezVousPatientAction::class);

    return $app;
};