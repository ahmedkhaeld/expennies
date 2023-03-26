<?php

namespace App\DataObjects;

class RegisterUserData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    )
    {
    }

}