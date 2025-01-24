<?php

namespace toubeelib_auth\application\actions;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key; 


class ValidateAction
{
    
    private string $jwtSecret;

    public function __construct(string $jwtSecret)
    {
        $this->jwtSecret = $jwtSecret;
    }

   public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $authHeader = $request->getHeader('Authorization');

        if (!$authHeader || empty($authHeader[0])) {
            throw new HttpException($request, "header invalide", 401);
        }

        $token = str_replace('Bearer ', '', $authHeader[0]);

        try {
            $decoded = JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
            $request = $request->withAttribute('auth', $decoded);
            return $response->withStatus(200)->withJson(['message' => 'Token is valid']);
        } catch (\Exception $e) {
            throw new HttpException($request, "Invalid token", 401);
        }
    }
}