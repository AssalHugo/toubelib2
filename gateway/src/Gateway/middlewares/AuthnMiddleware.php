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

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        
        if (!$request->hasHeader('Authorization')) {
            throw new HttpUnauthorizedException($request, "Authorization header is missing");
        }

        
        $token_line = $request->getHeaderLine('Authorization');
        list($token) = sscanf($token_line, "Bearer %s");

        
        $response = new Response();

        try {
            
            $response = $this->auth_service->__invoke($request, $response, ['token' => $token]);
        } catch (ConnectException | ServerException $e) {
            
            throw new HttpInternalServerErrorException($request, "Internal server error: " . $e->getMessage());
        } catch (ClientException $e) {
            
            match ($e->getCode()) {
                401 => throw new HttpUnauthorizedException($request, "Unauthorized: " . $e->getMessage()),
                default => throw new HttpInternalServerErrorException($request, "Internal server error: " . $e->getMessage()),
            };
        }

        
        return $next->handle($request);
    }
}