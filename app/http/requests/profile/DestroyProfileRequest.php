<?php

namespace app\http\requests\profile;

use app\http\requests\Request;

class DestroyProfileRequest implements Request {

    public static function role(): array
    {
        return [
            'password' => 'require|password|min:8',
        ];
    }
}