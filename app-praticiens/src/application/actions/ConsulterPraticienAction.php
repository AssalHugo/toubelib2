<?php

namespace toubeelibPraticien\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use toubeelibPraticien\application\renderer\JsonRenderer;
use toubeelibPraticien\core\dto\IdPraticienDTO;
use toubeelibPraticien\core\services\praticien\ServicePraticienInterface;
use toubeelibPraticien\core\services\praticien\ServicePraticienInvalidDataException;

class ConsulterPraticienAction extends AbstractAction
{
    private ServicePraticienInterface $servicePraticienInterface;

    public function __construct(ServicePraticienInterface $servicePraticienInterface)
    {
        $this->servicePraticienInterface = $servicePraticienInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['ID-PRATICIEN'] ?? null;

        $idPraticienDTO = new IdPraticienDTO($id);

        $idValidator = Validator::attribute('id', Validator::stringType()->notEmpty());

        $idPraticienDTO->setBusinessValidator($idValidator);
        try {
            $idPraticienDTO->validate();
        } catch (NestedValidationException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

        if ((filter_var($id, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) !== $id) {
            throw new HttpBadRequestException($rq, "Bad data format");
        }

        try {
            $praticien = $this->servicePraticienInterface->getPraticienById($idPraticienDTO);

            $data = [
                'praticien' => $praticien,
                'links' => [
                    'self' => [
                        "href" => '/praticiens/' . $id
                    ],
                    'modifier' => [
                        "href" => '/praticiens/' . $id
                    ],
                    'supprimer' => [
                        "href" => '/praticiens/' . $id
                    ],
                    'specialites' => [
                        "href" => '/praticiens/' . $id . '/specialites'
                    ]
                ]
            ];

            return JsonRenderer::render($rs, 200, $data);
        } catch (ServicePraticienInvalidDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
    }
}