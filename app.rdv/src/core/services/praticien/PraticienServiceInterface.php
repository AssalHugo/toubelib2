<?php

namespace toubeelibRdv\core\services\praticien;

use toubeelibRdv\core\dto\PraticienDTO;
use toubeelibRdv\core\dto\SpecialiteDTO;

interface PraticienServiceInterface
{

    public function getPraticienById(string $id): PraticienDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;
}