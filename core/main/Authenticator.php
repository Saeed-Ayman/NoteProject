<?php

namespace core\main;

use app\models\User;
use core\routes\Response;
use Exception;

class Authenticator
{
    public static function logout(): void
    {
        Session::destroy();
    }

    /**
     * @throws Exception
     */
    public static function login(array $validData): bool
    {
        $result = self::canLogin($validData);

        if (!$result) return false;

        static::attempted($result);
        return true;
    }

    public static function canLogin(array $validData): array|bool
    {
        $result = User::where('email = :email', [':email' => $validData['email']])->find();

        if ($result && password_verify($validData['password'], $result['password'])) {
            return $result;
        }

        return false;
    }

    public static function attempted(array $user): void
    {
        Session::setUser([
            'id' => $user['id'],
            'name' => ucfirst($user['first_name']) . ' ' . ucfirst($user['last_name']),
            'email' => $user['email'],
        ]);

        Session::refresh();
    }

    /**
     * @throws Exception
     */
    public static function register(array $validData): bool
    {
        return User::create($validData);
    }

    /**
     * @throws Exception
     */
    public static function authorize(string $model, mixed $key)
    {
        $data = $model::where('id = :id', ['id' => $key])->findOrFail();

        if ($data['user_id'] !== Session::user('id')) Response::abort(Response::FORBIDDEN);

        return $data;
    }
}