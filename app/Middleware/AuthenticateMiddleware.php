<?php

declare(strict_types = 1);

namespace App\Middleware;

use App\Contracts\AuthInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

//AuthenticateMiddleware is a middleware that checks if the user is authenticated
// and adds the user to the requests.
class AuthenticateMiddleware implements MiddlewareInterface
{

    public function __construct(private readonly AuthInterface $auth)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        return $handler->handle($request->withAttribute('user', $this->auth->user()));
    }
}
