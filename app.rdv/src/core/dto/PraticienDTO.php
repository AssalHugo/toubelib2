<?php

namespace toubeelibRdv\core\dto;

use toubeelibRdv\core\domain\entities\praticien\Praticien;
use toubeelibRdv\core\domain\entities\praticien\Specialite;
use toubeelibRdv\core\dto\DTO;

class PraticienDTO extends DTO
{
    protected string $ID;
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected string $specialitee_label;

    public function __construct(Praticien $p = null)
    {
        if ($p === null) {
            return;
        }
        $this->ID = $p->getID();
        $this->nom = $p->nom;
        $this->prenom = $p->prenom;
        $this->adresse = $p->adresse;
        $this->tel = $p->tel;
        $this->specialitee_label = $p->specialitee->label;
    }


    /**
     * Méthode pour créer un objet PraticienDTO à partir d'un object stdClass
     */
    public static function createFromStdClass(object $praticien): PraticienDTO
    {
        $p = new PraticienDTO();
        $p->ID = $praticien->praticien->ID;
        $p->nom = $praticien->praticien->nom;
        $p->prenom = $praticien->praticien->prenom;
        $p->adresse = $praticien->praticien->adresse;
        $p->tel = $praticien->praticien->tel;
        $p->specialitee_label = $praticien->praticien->specialitee_label;
        return $p;
    }

    /**
     * Méthode qui retourne un objet Praticien à partir d'un objet PraticienDTO
     */
    public function toEntity(): Praticien {
        $p = new Praticien($this->nom, $this->prenom, $this->adresse, $this->tel);
        $s = new Specialite($this->specialitee_label, '', '');
        $p->setSpecialite($s);
        return $p;
    }
}