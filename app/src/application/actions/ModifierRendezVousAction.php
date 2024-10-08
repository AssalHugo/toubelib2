<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\rdv\ServiceRendezVousInterface;
use toubeelib\core\services\rdv\ServiceRendezVousInvalidDataException;

class ModifierRendezVousAction extends AbstractAction
{

    private ServiceRendezVousInterface $serviceRendezVousInterface;

    /**
     * @param ServiceRendezVousInterface $serviceRendezVousInterface
     */
    public function __construct(ServiceRendezVousInterface $serviceRendezVousInterface)
    {
        $this->serviceRendezVousInterface = $serviceRendezVousInterface;
    }


    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $id = $args['ID-RDV'] ?? null;

        $data = $rq->getParsedBody();

        //Si ni le patient ni la specialitee ne sont renseignés
        if (!isset($data['specialitee']) && !isset($data['patient'])) {
            return JsonRenderer::render($rs, 400, ['error' => 'specialitee or patient are required']);
        }

        $specialitee = $data['specialitee'] ?? null;
        $patient = $data['patient'] ?? null;

        try {

            $rdv = $this->serviceRendezVousInterface->modifierRendezvous($id, $specialitee, $patient);

            $data = [
                'rdv' => $rdv,
                'links' => [
                    'self' => [
                        "href" => '/rdv/' . $id
                    ],
                    'modifier' => [
                        "href" => '/rdv/' . $id
                    ],
                    'annuler' => [
                        "href" => '/rdv/' . $id
                    ],
                    'praticien' => [
                        "href" => '/praticien/' . $rdv->getPraticien()
                    ],
                    'patient' => [
                        "href" => '/patient/' . $rdv->getIdPatient()
                    ]
                ]
            ];

            return JsonRenderer::render($rs, 200, $data);
        } catch (ServiceRendezVousInvalidDataException $e) {
            return JsonRenderer::render($rs, 400, ['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return JsonRenderer::render($rs, 500, ['error' => $e->getMessage()]);
        }
    }
}