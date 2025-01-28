<?php

require_once __DIR__ . '/../vendor/autoload.php';

$service = new toubeelibPraticien\core\services\praticien\ServicePraticien(new \toubeelibPraticien\infrastructure\repositories\ArrayPraticienRepository());

$pdto = new \toubeelibPraticien\core\dto\InputPraticienDTO('néplin', 'jean', 'vandeuve', '06 07 08 09 11', 'A');
$pdto2 = new \toubeelibPraticien\core\dto\InputPraticienDTO('némar', 'jean', 'lassou', '06 07 08 09 12', 'B');

$pe1 = $service->createPraticien($pdto);
print_r($pe1);
$pe2 = $service->createPraticien($pdto2);
print_r($pe2);

$pe11 = $service->getPraticienById($pe1->ID);
print_r($pe2);
$pe22 = $service->getPraticienById($pe2->ID);


try {
    $pe33 = $service->getPraticienById('ABCDE');
} catch (\toubeelibPraticien\core\services\praticien\ServicePraticienInvalidDataException $e){
    echo 'exception dans la récupération d\'un praticien :' . PHP_EOL;
    echo $e->getMessage(). PHP_EOL;
}

$pdto3 = new \toubeelibPraticien\core\dto\InputPraticienDTO('némar', 'jean', 'lassou', '06 07 08 09 12', 'Z');
try {
    $pe2 = $service->createPraticien($pdto3);
} catch (\toubeelibPraticien\core\services\praticien\ServicePraticienInvalidDataException $e) {
    echo 'exception dans la création d\'un praticien :' . PHP_EOL;
    echo $e->getMessage(). PHP_EOL;
}

try {
    print 'praticien prédéfini p1 : ' . PHP_EOL;
    $p1 = $service->getPraticienById('p1');
    print_r($p1);
} catch (\toubeelibPraticien\core\services\praticien\ServicePraticienInvalidDataException $e){
    echo 'exception dans la récupération d\'un praticien :' . PHP_EOL;
    echo $e->getMessage(). PHP_EOL;
}

