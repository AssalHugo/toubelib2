<?php
declare(strict_types=1);

use Slim\App;
use toubeelib\application\actions\ConsulterListePraticiensAction;
use toubeelib\application\actions\ConsulterPlanningPraticienAction;
use toubeelib\application\actions\ConsulterPraticienAction;
use toubeelib\application\actions\ListerDispoPraticienAction;
use toubeelib\application\actions\ListerRendezVousPatientAction;
use toubeelib\application\actions\ModifierOuGererCycleRendezVousAction;
use toubeelib\application\actions\AnnulerRendezVousAction;
use toubeelib\application\actions\ConsulterRendezVousAction;
use toubeelib\application\actions\CreerRendezVousAction;
use toubeelib\application\actions\HomeAction;
use toubeelib\application\actions\SigninAction;

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