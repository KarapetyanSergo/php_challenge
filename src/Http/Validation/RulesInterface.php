<?php
namespace App\Http\Validation;

interface RulesInterface
{
    public function check($value): bool;

    public function getMessage(): string;
}