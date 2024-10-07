<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\domain\entities\rendezvous\RendezVous;
use toubeelib\core\dto\InputRendezVousDTO;
use toubeelib\core\dto\RendezVousDTO;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RendezVousRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ServiceRendezVous implements ServiceRendezVousInterface
{

    private RendezVousRepositoryInterface $rendezVousRepository;

    public function __construct(RendezVousRepositoryInterface $rendezVousRepository)
    {
        $this->rendezVousRepository = $rendezVousRepository;
    }

    public function getRendezVousById(string $id): RendezVousDTO
    {
        try {
            $rendezVous = $this->rendezVousRepository->getRendezVousById($id);
            return new RendezVousDTO($rendezVous);
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServiceRendezVousInvalidDataException('invalid RendezVous ID');
        }
    }

    /**
     * @throws ServiceRendezVousInvalidDataException
     */
    public function modifierRendezvous(string $id, $specialitee, $patient): RendezVousDTO
    {
        try {
            $rendezVous = $this->rendezVousRepository->modifierRendezvous($id, $specialitee, $patient);
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServiceRendezVousInvalidDataException('invalid RendezVous ID');
        }

        return new RendezVousDTO($rendezVous);
    }

    /**
     * @throws ServiceRendezVousInvalidDataException
     */
    public function annulerRendezvous(string $id): RendezVousDTO
    {
        try {
            return new RendezVousDTO($this->rendezVousRepository->annulerRendezvous($id));
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServiceRendezVousInvalidDataException('invalid RendezVous ID');
        }
    }

    public function creerRendezvous(InputRendezVousDTO $r) : RendezVousDTO
    {
               
            $le_praticien = $this->praticienRepository->getPraticienById($praticien);
            
            $la_specialitee  =$this->praticienRepository->getSpecialiteById($le_praticien->specialitee);
    
    
            
            if (!$le_praticien) {
                        throw new ServiceRendezVousInvalidDataException('Praticien non trouve');
                    } 
            if (!$la_specialitee)
            {
                        throw new ServiceRendezVousInvalidDataException('Specialitee non valide');
            }
    
            foreach ($rdvs as $rdv){
                // #TODO Verification d'horaires 
            }

            $nrdv = new RendezVous($idPatient, \DateTimeImmutable::createFromFormat($creneau), $praticien, $specialitee,$type, $statut);
            $nrdv =$this->rendezVousRepository->save($nrdv);
                
            return new RendezVousDTO ($nrdv);
        
 
    }
}