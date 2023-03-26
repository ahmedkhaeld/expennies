<?php

declare(strict_types = 1);

namespace App\Contracts;

//UserInterface abstracts the User entity from the rest of the application.
interface UserInterface
{
    public function getId(): int;
    public function getPassword(): string;
}
