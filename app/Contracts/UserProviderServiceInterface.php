<?php

declare(strict_types = 1);

namespace App\Contracts;

//UserProviderServiceInterface abstracts how the application gets users from the database.
interface UserProviderServiceInterface
{
    public function getById(int $userId): ?UserInterface;

    public function getByCredentials(array $credentials): ?UserInterface;
}
