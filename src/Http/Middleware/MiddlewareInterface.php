<?php

namespace App\Http\Middleware;

interface MiddlewareInterface
{
    public function check(): bool;

    public function getMessage(): string;
}
