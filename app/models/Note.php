<?php

namespace app\models;

class Note extends Model
{
    protected static string $table = 'notes';
    protected static array $fillable = [
        'title',
        'body',
        'user_id',
    ];
}