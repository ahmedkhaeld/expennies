<?php

namespace App\Services;

use App\Contracts\SessionManagerInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestService
{
    public function __construct(
        private  readonly SessionManagerInterface $session
    ){

    }
    public function getValidatedReferer(ServerRequestInterface $request): string
    {
        $referer = $request->getHeader('referer')[0] ?? '';

        if (empty($referer)) {
           return $this->session->get('previousUrl');
        }

        $refererHost = parse_url($referer, PHP_URL_HOST);

        if ($refererHost!==$request->getUri()->getHost()){
            $referer=$this->session->get('previousUrl');
        }

        return $referer;
    }

}