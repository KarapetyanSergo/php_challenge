<?php

namespace App\Http\Middleware;

use App\Connection\DatabaseManager;
use App\Http\Middleware\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function check(): bool
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) return false;

        $accessToken = explode(' ', $headers['Authorization'])[1];

        $db = new DatabaseManager();
        $tokenExists = $db->where('access_token', '=', $accessToken)->get('user_access_token');
        
        if (empty($tokenExists)) return false;

        return true;
    }

    public function getMessage(): string
    {
        return 'Unauthorized';
    }
}