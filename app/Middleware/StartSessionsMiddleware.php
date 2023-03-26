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


        //put a base url in the session,
        // so we can depend on it for redirects in case we want to recover from invalidate url
        //TODO: Check for AJAX requests
        if($request->getMethod()==='GET'){
            $this->session->put('previousUrl', (string)$request->getUri());
        }

        //save the session
        $this->session->save();

        return $response;
    }
}
