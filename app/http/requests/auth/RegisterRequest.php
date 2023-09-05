<?php

namespace app\http\requests\auth;

use app\http\requests\Request;

class RegisterRequest implements Request
{

    public static function role(): array
    {
        return [
            'first_name' => 'require|ascii|min:3',
            'last_name' => 'require|ascii|min:3',
            'email' => 'require|email|unique:users,email|min:15',
            'password' => 'require|password|min:8',
        ];
    }
}