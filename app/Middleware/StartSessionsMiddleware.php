<?php

declare(strict_types = 1);

namespace App\Middleware;

use App\Contracts\SessionManagerInterface;
use App\Exception\SessionException;
use App\Services\RequestService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartSessionsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly SessionManagerInterface $session,
        private readonly RequestService $requestService
    )
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
        // Check for AJAX requests Done
        if ($request->getMethod() === 'GET' && ! $this->requestService->isXhr($request)) {
            $this->session->put('previousUrl', (string) $request->getUri());
        }

        //save the session
        $this->session->save();

        return $response;
    }
}
