<?php

namespace App\Contracts;

interface RequestValidatorFactoryInterface
{

    //accept fully qualified class name: Create a new instance of the given request validator class and return it
    public function make(string $class): RequestValidatorInterface;
}