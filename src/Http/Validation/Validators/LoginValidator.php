<?php
namespace App\Http\Validation\Validators;

use App\Http\Validation\BaseValidator;
use App\Http\Validation\Rules\StringRule;

class LoginValidator extends BaseValidator
{
    protected function rules(): array
    {
        return [
            'email' => [
                'required' => true,
                'conditions' => [
                    new StringRule()
                ]
            ],
            'password' => [
                'required' => true,
            ]
        ];
    }
}