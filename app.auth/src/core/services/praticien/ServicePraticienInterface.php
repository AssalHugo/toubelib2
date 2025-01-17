<?php

namespace toubeelib_auth\core\services\praticien;

use toubeelib_auth\core\dto\IdPraticienDTO;
use toubeelib_auth\core\dto\InputPraticienDTO;
use toubeelib_auth\core\dto\PraticienDTO;
use toubeelib_auth\core\dto\SpecialiteDTO;

interface ServicePraticienInterface
{

    public function createPraticien(InputPraticienDTO $p): PraticienDTO;
    public function getPraticienById(IdPraticienDTO $id): PraticienDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;


}