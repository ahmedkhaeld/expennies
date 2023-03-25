<?php

declare(strict_types = 1);

namespace App\Middleware;

use App\Exception\SessionException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartSessionsMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Start the session if it hasn't already been started and headers haven't already been sent
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException('Session has already been started');
        }

        if (headers_sent($fileName, $line)) {
            throw new SessionException('Headers already sent');
        }

        session_set_cookie_params([
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        session_start();

        //process the request and get the response
        $response = $handler->handle($request);

        //close the session and write the session data to the session storage
        session_write_close();

        return $response;
    }
}
