<?php

require_once __DIR__ . '/../vendor/autoload.php';

use toubeelibRdv\core\dto\InputRendezVousDTO;
use toubeelibRdv\core\services\rdv\ServiceRendezVous;
use toubeelibRdv\core\services\rdv\ServiceRendezVousInvalidDataException;


$service = new ServiceRendezVous(new \toubeelibRdv\infrastructure\repositories\ArrayRdvRepository());

try {
    $re33 = $service->getRendezVousById('r1');
} catch (ServiceRendezVousInvalidDataException $e) {
    echo 'Exception dans la récupération d\'un rendez-vous :' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
}

print_r($re33); // Affiche les détails du rendez-vous récupéré


try {
    $re33 = $service->modifierRendezvous('r1', 'A', 'p1');
} catch (ServiceRendezVousInvalidDataException $e) {
    echo 'Exception dans la modification d\'un rendez-vous :' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
}

print_r($re33);