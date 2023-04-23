<?php

return [
    'GET' => [
        '/users' => [
            'controller' => 'App\Http\Controllers\Api\UserController@index',
        ],
    ],
    'POST' => [
        '/register' => [
            'controller' => 'App\Http\Controllers\Auth\AuthController@register',
        ],
        '/login' => [
            'controller' => 'App\Http\Controllers\Auth\AuthController@login',
        ]
    ],
    'PUT' => [
        '/users/auth' => [
            'controller' => 'App\Http\Controllers\Api\UserController@update',
            'middleware' => 'App\Http\Middleware\AuthMiddleware',
        ]
    ]
];