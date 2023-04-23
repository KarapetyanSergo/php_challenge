<?php

namespace App\Http\Validation;

abstract class BaseValidator
{
    public $errors = [];

    abstract protected function rules(): array;

    public function handle(array $requestData): void
    {
        $rules = $this->rules();

        foreach ($rules as $parameter => $parameterRules) {
            if (isset($parameterRules['required']) && $parameterRules['required'] && !isset($requestData[$parameter])) {
                $this->errors[$parameter][] = $parameter.' is required';
                continue;
            }

            if (isset($parameterRules['conditions'])) {                
                foreach ($parameterRules['conditions'] as $condition) {
                    if (!$condition->check($requestData[$parameter])) {
                        $this->errors[$parameter][] = $condition->getMessage();
                    }
                }
            }
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}