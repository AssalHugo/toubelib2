<?php

namespace toubeelibPraticien\core\services\rdv;


use toubeelibPraticien\core\dto\IdRendezVousDTO;
use toubeelibPraticien\core\dto\InputDispoPraticienDTO;
use toubeelibPraticien\core\dto\InputRendezVousDTO;
use toubeelibPraticien\core\dto\ModificationRendezVousDTO;
use toubeelibPraticien\core\dto\PlanningPraticienDTO;
use toubeelibPraticien\core\dto\RendezVousDTO;
use toubeelibPraticien\core\services\rdv\ServiceRendezVousInvalidDataException;

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