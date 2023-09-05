<?php

namespace app\http\requests\auth;

use app\http\requests\Request;

class LoginRequest implements Request
{
    public static function role(): array
    {
        return [
            'email' => 'require',
            'password' => 'require',
        ];
    }
}