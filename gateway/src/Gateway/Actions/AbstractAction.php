<?php

namespace Gateway\Actions;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction
{

    protected ClientInterface $remote;

    public function __construct(ClientInterface $client)
    {
        $this->remote = $client;
    }

    abstract public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface;

}