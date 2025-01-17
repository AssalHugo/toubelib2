<?php

namespace toubeelibRdv\core\repositoryInterfaces;

use toubeelibRdv\core\domain\entities\praticien\Praticien;
use toubeelibRdv\core\domain\entities\praticien\Specialite;

interface PraticienRepositoryInterface
{

    public function getSpecialiteById(string $id): Specialite;
    public function save(Praticien $praticien): string;
    public function getPraticienById(string $id): Praticien;

}