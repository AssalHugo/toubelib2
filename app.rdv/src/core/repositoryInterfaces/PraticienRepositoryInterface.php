<?php

namespace  toubeelib_rdv\core\repositoryInterfaces;

use toubeelib_rdv\core\domain\entities\praticien\Praticien;
use toubeelib_rdv\core\domain\entities\praticien\Specialite;

interface PraticienRepositoryInterface
{

    public function getSpecialiteById(string $id): Specialite;
    public function save(Praticien $praticien): string;
    public function getPraticienById(string $id): Praticien;

}