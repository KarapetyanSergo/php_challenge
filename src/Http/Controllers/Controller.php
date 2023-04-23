<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function getSuccessResponse($data): array
    {
        return [
            'data' => $data
        ];
    }

    protected function getErrorResponse($data, int $statusCode): array
    {
        http_response_code($statusCode);

        return [
            'message' => $data
        ];
    }
}