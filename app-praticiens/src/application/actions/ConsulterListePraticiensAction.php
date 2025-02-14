<?php

namespace toubeelibPraticien\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelibPraticien\application\renderer\JsonRenderer;
use toubeelibPraticien\core\services\praticien\ServicePraticienInterface;

class ConsulterListePraticiensAction extends AbstractAction
{

    private ServicePraticienInterface $servicePraticienInterface;

    public function __construct(ServicePraticienInterface $servicePraticienInterface)
    {
        $this->servicePraticienInterface = $servicePraticienInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $praticiens = $this->servicePraticienInterface->getAllPraticiens();

        $data = [
            'praticiens' => $praticiens,
            'links' => [
                'self' => [
                    "href" => '/praticiens'
                ]
            ]
        ];

        return JsonRenderer::render($rs, 200, $data);
    }
}