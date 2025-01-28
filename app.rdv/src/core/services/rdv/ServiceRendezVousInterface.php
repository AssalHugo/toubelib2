<?php

namespace toubeelibRdv\core\services\rdv;


use toubeelibRdv\core\dto\IdRendezVousDTO;
use toubeelibRdv\core\dto\InputDispoPraticienDTO;
use toubeelibRdv\core\dto\InputRendezVousDTO;
use toubeelibRdv\core\dto\ModificationRendezVousDTO;
use toubeelibRdv\core\dto\PlanningPraticienDTO;
use toubeelibRdv\core\dto\RendezVousDTO;
use toubeelibRdv\core\services\rdv\ServiceRendezVousInvalidDataException;

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
    public function sendMessage(array $messageData): void;

}