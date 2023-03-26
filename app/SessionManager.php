<?php

declare(strict_types = 1);
namespace App;

use App\Contracts\SessionManagerInterface;
use App\DataObjects\SessionConfig;
use App\Exception\SessionException;

class SessionManager implements SessionManagerInterface
{

    public function __construct(private readonly SessionConfig $options)
    {
    }

    public function start(): void
    {
         // Start the session if it hasn't already been started and headers haven't already been sent
        if ($this->isActive()) {
            throw new SessionException('Session has already been started');
        }

        if (headers_sent($fileName, $line)) {
            throw new SessionException('Headers already sent'. $fileName . ':' . $line);
        }

        session_set_cookie_params(
            [
                'secure'=>$this->options->secure,
                'httponly'=>$this->options->httponly,
                'samesite'=>$this->options->samesite->value,

            ]
        );

        if (!empty($this->options->name)) {
            session_name($this->options->name);
        }

        if(! session_start()){
            throw new SessionException('Session failed to start');
        }
    }

    public function save(): void
    {
        //close the session and write the session data to the session storage
        session_write_close();
    }

    public function isActive():bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function regenerate():bool
    {
        return session_regenerate_id();
    }

    public function forget(string $key):void
    {
        unset($_SESSION[$key]);
    }

    public function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }


    //check if key exists in session and return it if it does, otherwise return null
    public function get(string $key,mixed $default=null): mixed
    {
       return array_key_exists($key,$_SESSION) ? $_SESSION[$key] : $default;
    }

    public function flash(string $key, array $messages):void
    {
       $_SESSION[$this->options->flashName][$key] = $messages;
    }

    public function getFlash(string $key):array
    {
        $messages=$_SESSION[$this->options->flashName][$key]??[];
        unset($_SESSION[$this->options->flashName][$key]);
        return $messages;
    }
}