<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Tables\Users\UsersTable;

class UserController extends Controller
{
    public function index(Request $request): array
    {
        $data = $request->getRequestData();

        $users = new UsersTable();

        if (isset($data['filters'])) {
            foreach ($data['filters'] as $columnName => $value) {
                $users->where($columnName, 'LIKE', '%'.$value.'%');
            }
        }

        return $this->getSuccessResponse([
            'users' => $users->get()->toArray(),
        ]);
    }

    public function update(Request $request): array
    {
        $user = (new UsersTable())->getAuthUser();

        return $this->getSuccessResponse([
            'user' => (new UsersTable())->updateById($request->getRequestData(), $user->id),
        ]);
    }
}