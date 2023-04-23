<?php

namespace App\Tables\Users;

use App\Connection\DatabaseManager;
use App\Tables\Table;

class UsersTable extends Table
{
    public $table = 'users';

    public $columns = [
        'first_name',
        'last_name',
        'email',
        'birth_date',
        'image'
    ];

    public function getAuthUser(): User
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) return null;

        $accessToken = explode(' ', $headers['Authorization'])[1];

        $db = new DatabaseManager();
        $tokenExists = $db->where('access_token', '=', $accessToken)->get('user_access_token');

        if (empty($tokenExists)) return false;

        return $this->getById($tokenExists[0]['user_id']);
    }
}