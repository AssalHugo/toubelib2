<?php

namespace toubeelibPraticien\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use toubeelibPraticien\application\renderer\JsonRenderer;
use toubeelibPraticien\core\services\praticien\ServicePraticienInterface;
use toubeelibPraticien\core\services\praticien\ServicePraticienInvalidDataException;

class ConsulterSpecialiteAction extends AbstractAction
{
    private ServicePraticienInterface $servicePraticienInterface;

    public function __construct(ServicePraticienInterface $servicePraticienInterface)
    {
        $this->servicePraticienInterface = $servicePraticienInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['ID-SPECIALITE'] ?? null;

        $idValidator = Validator::stringType()->notEmpty();

        try {
            $idValidator->assert($id);
        } catch (NestedValidationException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

        if ((filter_var($id, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) !== $id) {
            throw new HttpBadRequestException($rq, "Bad data format");
        }

        try {
            $specialite = $this->servicePraticienInterface->getSpecialiteById($id);

            $data = [
                'specialite' => $specialite,
                'links' => [
                    'self' => [
                        "href" => '/specialites/' . $id
                    ],
                    'modifier' => [
                        "href" => '/specialites/' . $id
                    ],
                    'supprimer' => [
                        "href" => '/specialites/' . $id
                    ],
                    'praticiens' => [
                        "href" => '/specialites/' . $id . '/praticiens'
                    ]
                ]
            ];

            return JsonRenderer::render($rs, 200, $data);
        } catch (ServicePraticienInvalidDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
    }
}