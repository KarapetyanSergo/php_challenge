<?php

namespace App\Traits;

use App\Connection\DatabaseManager;

trait Authenticable
{
    function createToken(int $length = 1000): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        (new DatabaseManager())->create('user_access_token', [
            'user_id' => $this->id,
            'access_token' => $randomString,
        ]);

        return $randomString;
    }
}