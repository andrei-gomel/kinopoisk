<?php

namespace App\Kernel\Session;

interface SessionInterface
{
    public function set(string $key, $value): void;

    public function get(string $key, $default = null): string|array;

    public function has(string $key): bool;

    public function getFlash(string $key, $default = null);

    public function destroy(): void;

    public function remove(string $key): void;
}