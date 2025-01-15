<?php

namespace Gateway\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;

class SigninAction extends AbstractAction 
{
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $body = $rq->getParsedBody();
        try {
            // Transférer la requête vers le service toubeelib
            $apiResponse = $this->httpClient->post('/auth/signin', [
                'json' => $body, // Corps de la requête transféré en JSON
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            // Copier la réponse reçue du service toubeelib
            $rs->getBody()->write($apiResponse->getBody()->getContents());
            return $rs->withStatus($apiResponse->getStatusCode())
                            ->withHeader('Content-Type', 'application/json');

        } catch (ClientException $e) {
            match ($e->getCode()) {
                400, 404 => throw new HttpNotFoundException($rq, "Ressource non trouvée"),
                401 => throw new HttpUnauthorizedException($rq, "Non autorisé"),
                403 => throw new HttpForbiddenException($rq, "Accès refusé"),
                default => throw new HttpInternalServerErrorException($rq, "Erreur interne du serveur : " . $e->getMessage()),
            };
        }
        catch (ConnectException|ServerException $e) {
            throw new HttpInternalServerErrorException($rq, "Erreur interne du serveur" . $e->getMessage() . $e->getResponse()->getBody());
        }
    }

}