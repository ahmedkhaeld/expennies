<?php

namespace App\Contracts;

interface SessionManagerInterface
{

    public function start(): void;

    public function save(): void;

    public function isActive():bool;

    public function put(string $key, mixed $value): void;

    public function get(string $key, mixed $default = null): mixed;

    public function regenerate():bool;

    public function forget(string $key):void;

    public function flash(string $key, array $messages):void;

    public function getFlash(string $key):array;


}