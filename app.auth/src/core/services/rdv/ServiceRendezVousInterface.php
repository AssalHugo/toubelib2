<?php

namespace toubeelib_auth\core\services\rdv;


use toubeelib_auth\core\dto\IdRendezVousDTO;
use toubeelib_auth\core\dto\InputDispoPraticienDTO;
use toubeelib_auth\core\dto\InputRendezVousDTO;
use toubeelib_auth\core\dto\ModificationRendezVousDTO;
use toubeelib_auth\core\dto\PlanningPraticienDTO;
use toubeelib_auth\core\dto\RendezVousDTO;
use toubeelib_auth\core\services\rdv\ServiceRendezVousInvalidDataException;

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