<?php

namespace toubeelibRdv\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use toubeelibRdv\application\renderer\JsonRenderer;
use toubeelibRdv\core\dto\IdRendezVousDTO;
use toubeelibRdv\core\services\rdv\ServiceRendezVousInterface;
use toubeelibRdv\core\services\rdv\ServiceRendezVousInvalidDataException;

class ConsulterRendezVousAction extends AbstractAction
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
        //On essaye de récupérer l'id donné en paramètre
        $id = $args['ID-RDV'] ?? null;

        $idRendezVousDTO = new IdRendezVousDTO($id);

        $idValidator = Validator::attribute('id', Validator::stringType()->notEmpty());

        $idRendezVousDTO->setBusinessValidator($idValidator);
        try {
            $idRendezVousDTO->validate();
        } catch (NestedValidationException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

        if ((filter_var($id, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) !== $id) {
            throw new HttpBadRequestException($rq, "Bad data format");
        }

        try {
            $rdv = $this->serviceRendezVousInterface->getRendezVousById($idRendezVousDTO);

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
                        "href" => '/praticiens/' . $rdv->getPraticien()
                    ],
                    'patient' => [
                        "href" => '/patient/' . $rdv->getIdPatient()
                    ]
                ]
            ];
            return JsonRenderer::render($rs, 200, $data);
        } catch (ServiceRendezVousInvalidDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

    }
}