<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Validation\Validators\LoginValidator;
use App\Tables\Users\UsersTable;

class AuthController extends Controller
{
    public function register(Request $request): array
    {
        $data = $request->getRequestData();

        $validator = new LoginValidator();
        $validator->handle($data);

        if ($validator->getErrors()) return $this->getErrorResponse($validator->getErrors(), 422);

        $user = (new UsersTable())->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'birth_date' => $data['birth_date'],
            'image' => $data['image'] ?? null,
        ]);


        $userResponse = $user->toArray();
        unset($userResponse['password']);

        return $this->getSuccessResponse([
            'user' => $userResponse,
            'token' => $user->createToken(),
        ]);
    }

    public function login(Request $request): array
    {
        $data = $request->getRequestData();

        $validator = new LoginValidator();
        $validator->handle($data);

        if ($validator->getErrors()) return $this->getErrorResponse($validator->getErrors(), 422);

        $user = (new UsersTable())
        ->where('email', '=', $data['email'])
        ->get()
        ->first();

        if (!$user || !password_verify($data['password'], $user->password)) return $this->getErrorResponse('Incorrect email or password!', 400);

        $userResponse = $user->toArray();
        unset($userResponse['password']);

        return [
            'user' => $userResponse,
            'token' => $user->createToken(),
        ];
    }
}