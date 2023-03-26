<?php

declare(strict_types = 1);

namespace App\Contracts;

//UserProviderServiceInterface abstracts how the application gets users from the database.
use App\DataObjects\RegisterUserData;
use App\Entity\User;

interface UserProviderServiceInterface
{
    public function getById(int $userId): ?UserInterface;

    public function getByCredentials(array $credentials): ?UserInterface;

    public function createUser(RegisterUserData $data): UserInterface;
}
