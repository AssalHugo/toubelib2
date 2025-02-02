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

    //La route s'utilise de la manière suivante : /praticiens/{ID-PRATICIEN}/disponibilites?debut=2024-06-01T08:00:00&fin=2024-06-01T18:00:00
    $app->get('/praticiens/{ID-PRATICIEN}/disponibilites', ListerDispoPraticienAction::class);

    $app->get('/praticiens/{ID-PRATICIEN}', ConsulterPraticienAction::class);

    $app->get('/praticiens', ConsulterListePraticiensAction::class);

    //La route s'utilise de la manière suivante : /praticiens/4g5h6i7j-8901-1121-3141-6171k9l0m1n2/planning?debut=2022-06-01T08:00:00&fin=2025-06-01T18:00:00&specialitee=CAR&type=Consultation
    $app->get('/praticiens/{ID-PRATICIEN}/planning', ConsulterPlanningPraticienAction::class);

    $app->get('/patients/{ID-PATIENT}/rdvs', ListerRendezVousPatientAction::class);

    return $app;
};