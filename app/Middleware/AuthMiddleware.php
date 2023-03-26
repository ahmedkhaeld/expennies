<?php

namespace App\Middleware;

use App\Contracts\AuthInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly AuthInterface $auth
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //check if user is logged in add the user to the request and continue, otherwise  redirect to login page,
        if ($user=$this->auth->user()) {
            return $handler->handle($request->withAttribute('user',$user));

        }
        return $this->responseFactory->createResponse(302)->withHeader('Location', '/login');

    }
}
{

}