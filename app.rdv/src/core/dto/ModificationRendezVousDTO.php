<?php

namespace toubeelib_rdv\core\dto;

use toubeelib_rdv\core\domain\entities\rendezvous\RendezVous;

class ModificationRendezVousDTO extends DTO
{
    protected string $id;
    protected string $idPatient;
    protected string $specialitee;

    public function __construct(string $id, string $idPatient, string $specialitee)
    {
        $this->id = $id;
        $this->idPatient = $idPatient;
        $this->specialitee = $specialitee;
    }
}