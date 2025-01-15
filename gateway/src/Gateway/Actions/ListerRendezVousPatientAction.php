<?php

namespace Gateway\Actions;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;

class ListerRendezVousPatientAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            return $this->remote->get('praticiens/{$args}/rdvs' . $args['id']);
        }
        catch (ClientException $e) {
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