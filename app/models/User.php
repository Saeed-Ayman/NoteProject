<?php

namespace app\models;

class User extends Model
{

    protected static string $table = 'users';
    protected static array $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected static array $hashed = [
        'password',
    ];
}