<?php

namespace toubeelib_auth\core\dto;

use toubeelib_auth\core\domain\entities\praticien\Praticien;
use toubeelib_auth\core\dto\DTO;

class PraticienDTO extends DTO
{
    protected string $ID;
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected string $specialitee_label;

    public function __construct(Praticien $p)
    {
        $this->ID = $p->getID();
        $this->nom = $p->nom;
        $this->prenom = $p->prenom;
        $this->adresse = $p->adresse;
        $this->tel = $p->tel;
        $this->specialitee_label = $p->specialitee->label;
    }

}