<?php

namespace toubeelib_rdv\core\services\rdv;


use toubeelib_rdv\core\dto\IdRendezVousDTO;
use toubeelib_rdv\core\dto\InputDispoPraticienDTO;
use toubeelib_rdv\core\dto\InputRendezVousDTO;
use toubeelib_rdv\core\dto\ModificationRendezVousDTO;
use toubeelib_rdv\core\dto\PlanningPraticienDTO;
use toubeelib_rdv\core\dto\RendezVousDTO;
use toubeelib_rdv\core\services\rdv\ServiceRendezVousInvalidDataException;

interface ServiceRendezVousInterface
{

    public function getRendezVousById(IdRendezVousDTO $idRendezVousDTO): RendezVousDTO;
    public function creerRendezVous(InputRendezVousDTO $r) : RendezVousDTO;

    /**
     * @throws ServiceRendezVousInvalidDataException
     */
    public function modifierRendezvous(ModificationRendezVousDTO $modificationRendezVousDTO): RendezVousDTO;
    public function annulerRendezvous(string $id): RendezVousDTO;

    /**
     * @throws ServiceRendezVousInvalidDataException
     */
    public function listerDispoPraticien(InputDispoPraticienDTO $inputDispoPraticienDTO): array;

    /**
     * @throws ServiceRendezVousInvalidDataException
     */
    public function listerPlanningPraticien(PlanningPraticienDTO $planningPraticienDTO): array;
}