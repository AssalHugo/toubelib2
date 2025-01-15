<?php

namespace toubeelibPraticien\core\dto;

class IdPatientDTO extends DTO
{

    protected string $idPatient;

    public function __construct(string $idPatient)
    {
        $this->idPatient = $idPatient;
    }
}