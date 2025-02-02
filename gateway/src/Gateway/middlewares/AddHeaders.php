<?php

namespace Gateway\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AddHeaders
{
    public function __invoke(
        ServerRequestInterface  $rq,
        RequestHandlerInterface $next): ResponseInterface
    {
        
        $origin = $rq->hasHeader('Origin') ? $rq->getHeaderLine('Origin') : '*';
        $response = $next->handle($rq);

        $response = $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET, DELETE, HEAD, PATCH, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Authorization', 'Content-Type')
            ->withHeader('Access-Control-Max-Age', 3600)
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Content-Language', 'fr-FR')
            ->withHeader('Cache-Control', 'max-age=' . 60 * 60 * 2);

        return $response;
    }
}


