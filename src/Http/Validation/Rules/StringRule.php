<?php
namespace App\Http\Validation\Rules;

use App\Http\Validation\RulesInterface;

class StringRule implements RulesInterface
{
    public function check($value): bool
    {
        return is_string($value);
    }

    public function getMessage(): string
    {
        return 'parameter must be a string';
    }
}