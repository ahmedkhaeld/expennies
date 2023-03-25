<?php

declare(strict_types = 1);

namespace App\Contracts;

//AuthInterface abstracts the authentication logic from the rest of the application.
interface AuthInterface
{
    //user get the authenticated user for the request
    public function user(): ?UserInterface;

    public function attemptLogin(array $credentials): bool;

    public function checkCredentials(UserInterface $user, array $credentials): bool;

    public function logOut(): void;
}
