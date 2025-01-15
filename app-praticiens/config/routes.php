<?php
declare(strict_types=1);

use Slim\App;
use toubeelibPraticien\application\actions\ConsulterListePraticiensAction;
use toubeelibPraticien\application\actions\ConsulterPlanningPraticienAction;
use toubeelibPraticien\application\actions\ConsulterPraticienAction;
use toubeelibPraticien\application\actions\ListerDispoPraticienAction;
use toubeelibPraticien\application\actions\ListerRendezVousPatientAction;
use toubeelibPraticien\application\actions\ModifierOuGererCycleRendezVousAction;
use toubeelibPraticien\application\actions\AnnulerRendezVousAction;
use toubeelibPraticien\application\actions\ConsulterRendezVousAction;
use toubeelibPraticien\application\actions\CreerRendezVousAction;
use toubeelibPraticien\application\actions\HomeAction;
use toubeelibPraticien\application\actions\SigninAction;

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