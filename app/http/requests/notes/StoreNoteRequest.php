<?php

namespace app\http\requests\notes;

use app\http\requests\Request;

class StoreNoteRequest implements Request
{

    public static function role(): array
    {
        return [
            'title' => 'require|between:5,50|ascii_number',
            'body' => 'require|between:25,255'
        ];
    }
}