<?php

namespace app\http\requests\auth\password;

use app\http\requests\Request;

class EditPasswordRequest implements Request
{
    public static function role(): array
    {
        return [
            'password' => 'require',
            'new-password' => 'require|password|min:8'
        ];
    }
}