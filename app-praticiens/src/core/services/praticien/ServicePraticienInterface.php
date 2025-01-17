<?php

namespace toubeelibPraticien\core\services\praticien;

use toubeelibPraticien\core\dto\IdPraticienDTO;
use toubeelibPraticien\core\dto\InputPraticienDTO;
use toubeelibPraticien\core\dto\PraticienDTO;
use toubeelibPraticien\core\dto\SpecialiteDTO;

interface ServicePraticienInterface
{

    public function createPraticien(InputPraticienDTO $p): PraticienDTO;
    public function getPraticienById(IdPraticienDTO $id): PraticienDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;


}