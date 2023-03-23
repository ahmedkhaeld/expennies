<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

class FormValidationErrorsMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly Twig $twig)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // If there are errors in the session, add them to the Twig environment
        if (! empty($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];

            $this->twig->getEnvironment()->addGlobal('errors', $errors);

            unset($_SESSION['errors']);
        }

        return $handler->handle($request);
    }

}