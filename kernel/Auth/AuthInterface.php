<?php

namespace App\Kernel\Auth;

interface AuthInterface
{
    public function attempt(string $usernmae, string $password): bool;

    public function logout(): void;

    public function check(): bool;

    public function user(): ?User;

    public function sessionField(): string;
}