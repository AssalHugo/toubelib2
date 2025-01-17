<?php

namespace toubeelibPraticien\core\repositoryInterfaces;

use toubeelibPraticien\core\domain\entities\praticien\Praticien;
use toubeelibPraticien\core\domain\entities\praticien\Specialite;

interface PraticienRepositoryInterface
{

    public function getSpecialiteById(string $id): Specialite;
    public function save(Praticien $praticien): string;
    public function getPraticienById(string $id): Praticien;

}