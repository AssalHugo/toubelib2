<?php

namespace Gateway\Actions;

use Gateway\renderer\JsonRenderer;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

class ListePraticiensAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $response = $this->remote->get('/praticiens');
            $response_data = json_decode((string)$response->getBody(), true);
            return JsonRenderer::render($response_data, 200, $response);
        } catch (ConnectException|ServerException $e) {
            throw new HttpInternalServerErrorException($request, "Erreur interne du serveur" . $e->getMessage());
        } catch (ClientException $e) {
            match ($e->getCode()) {
                404 => throw new HttpNotFoundException($request, "Ressource non trouvée"),
                403 => throw new HttpForbiddenException($request, "Accès refusé"),
                default => throw new HttpInternalServerErrorException($request, "Erreur interne du serveur"),
            };
        }
    }
}