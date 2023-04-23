<?php

namespace App\Http\Validation\Validators;

use App\Http\Validation\BaseValidator;
use App\Http\Validation\Rules\StringRule;

class RegisterValidator extends BaseValidator
{
    protected function rules(): array
    {
        return [
            'first_name' => [
                'required' => true,
                'conditions' => [
                    new StringRule()
                ]
            ],
            'last_name' => [
                'required' => true,
                'conditions' => [
                    new StringRule()
                ]
            ],
            'password' => [
                'required' => true,
                'conditions' => [
                    new StringRule()
                ]
            ],
            'birth_date' => [
                'required' => true,
            ],
            'image' => [
                'required' => true,
            ],
            'email' => [
                'required' => true,
            ]
        ];
    }
}