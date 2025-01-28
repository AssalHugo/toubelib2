<?php

namespace Gateway\Actions;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;

class GenericGetCatalogAction00 extends AbstractAction
{
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $method = $rq->getMethod();
        $path = $rq->getUri()->getPath();
        $options = ['query' => $rq->getQueryParams()];
        

        if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
            $options['json'] = $rq->getParsedBody();
        }

        $auth = $rq->getHeader('Authorization') ?? null;

        if (!empty($auth)) {
            $options['headers'] = ['Authorization' => $auth];                        
        }

        try {
   
            return $this->remote->request($method, $path, $options);
            
        }catch (ClientException $e) {
            match ($e->getCode()) {
                400 => throw new HttpBadRequestException($rq, "Requête incorrecte : " . $e->getMessage()),
                404 => throw new HttpNotFoundException($rq, "Ressource non trouvée : " . $e->getMessage()),
                401 => throw new HttpUnauthorizedException($rq, "Non autorisé :" . $e->getMessage()),
                403 => throw new HttpForbiddenException($rq, "Accès refusé : " . $e->getMessage()),
                default => throw new HttpInternalServerErrorException($rq, "Erreur interne du serveur : " . $e->getMessage()),
            };
        }
        catch (ConnectException|ServerException $e) {
            throw new HttpInternalServerErrorException($rq, "Erreur interne du serveur" . $e->getMessage() . $e->getResponse()->getBody());
        }
    }
}