<?php

namespace Gateway\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Gateway\Actions\ValidateAction;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Psr7\Response;
use Slim\Exception\HttpInternalServerErrorException;

class AuthnMiddleware
{
    private ValidateAction $auth_service;

    public function __construct(ValidateAction $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        
        if (!$request->hasHeader('Authorization')) {
            throw new HttpUnauthorizedException($request, "Authorization header is missing");
        }

        
        $authHeader = $request->getHeader('Authorization')[0];
        $token = str_replace('Bearer ', '', $authHeader);

        try {
            
            $response = $this->auth_service->__invoke($request, new Response(), [
                'json' => ['token' => $token]
                ]
        );
            
            
            return $handler->handle($request);
            
        } catch (ConnectException | ServerException $e) {
            
            throw new HttpInternalServerErrorException($request, "Server error: {$e->getMessage()}");
        } catch (ClientException $e) {
            
            throw new HttpUnauthorizedException($request, "Unauthorized: {$e->getMessage()}");
        }
    }
}