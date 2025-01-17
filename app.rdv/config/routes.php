<?php
declare(strict_types=1);

use Slim\App;
use toubeelib_rdv\application\actions\ConsulterListePraticiensAction;
use toubeelib_rdv\application\actions\ConsulterPlanningPraticienAction;
use toubeelib_rdv\application\actions\ConsulterPraticienAction;
use toubeelib_rdv\application\actions\ListerDispoPraticienAction;
use toubeelib_rdv\application\actions\ListerRendezVousPatientAction;
use toubeelib_rdv\application\actions\ModifierOuGererCycleRendezVousAction;
use toubeelib_rdv\application\actions\AnnulerRendezVousAction;
use toubeelib_rdv\application\actions\ConsulterRendezVousAction;
use toubeelib_rdv\application\actions\CreerRendezVousAction;
use toubeelib_rdv\application\actions\HomeAction;
use toubeelib_rdv\application\actions\SigninAction;

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