<?php

namespace toubeelibRdv\core\dto;

class CreneauRendezVousDTO extends DTO
{

    protected string $creneau;

    public function __construct(string $creneau)
    {
        $this->creneau = $creneau;
    }
}