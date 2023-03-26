<?php

declare(strict_types = 1);

namespace App\Middleware;

use App\Contracts\SessionManagerInterface;
use App\Exception\SessionException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartSessionsMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly SessionManagerInterface $session)
    {
    }
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //start the session
        $this->session->start();

        //process the request and get the response
        $response = $handler->handle($request);

        //save the session
        $this->session->save();

        return $response;
    }
}
