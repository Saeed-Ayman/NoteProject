<?php

namespace app\http\requests\notes;

use app\http\requests\Request;

class UpdateNoteRequest implements Request
{

    public static function role(): array
    {
        return [
            'id' => 'require',
            'title' => 'require|between:5,50|ascii_number',
            'body' => 'require|between:25,255'
        ];
    }
}