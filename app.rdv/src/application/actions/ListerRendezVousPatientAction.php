<?php

namespace toubeelibRdv\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use Slim\Exception\HttpBadRequestException;
use toubeelibRdv\application\renderer\JsonRenderer;
use toubeelibRdv\core\dto\IdPatientDTO;
use toubeelibRdv\core\services\rdv\ServiceRendezVousInterface;

class ListerRendezVousPatientAction extends AbstractAction
{

    private ServiceRendezVousInterface $serviceRendezVousInterface;

    public function __construct(ServiceRendezVousInterface $serviceRendezVousInterface)
    {
        $this->serviceRendezVousInterface = $serviceRendezVousInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $patientId = $args['ID-PATIENT'] ?? null;

        $idPatientDTO = new IdPatientDTO($patientId);

        $idpatientValidator = v::stringType()->notEmpty();

        try {
            $idpatientValidator->assert($patientId);
        } catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

        if ((filter_var($patientId, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) !== $patientId) {
            throw new HttpBadRequestException($rq, "Bad data format");
        }

        try {
            $rdvs = $this->serviceRendezVousInterface->getRendezVousPatient($idPatientDTO);
        } catch (\toubeelibRdv\core\services\rdv\ServiceRendezVousInvalidDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

        return JsonRenderer::render($rs, 200, $rdvs);
    }
}