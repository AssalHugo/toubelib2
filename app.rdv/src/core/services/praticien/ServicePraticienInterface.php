<?php

namespace toubeelib_rdv\core\services\praticien;

use toubeelib_rdv\core\dto\IdPraticienDTO;
use toubeelib_rdv\core\dto\InputPraticienDTO;
use toubeelib_rdv\core\dto\PraticienDTO;
use toubeelib_rdv\core\dto\SpecialiteDTO;

interface ServicePraticienInterface
{

    public function createPraticien(InputPraticienDTO $p): PraticienDTO;
    public function getPraticienById(IdPraticienDTO $id): PraticienDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;


}