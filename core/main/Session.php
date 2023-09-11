<?php

namespace core\main;

class Session
{
    public static function start(): void
    {
        session_start();
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null)
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    public static function user(string $key, mixed $default = null)
    {
        return $_SESSION['user'][$key] ?? $default;
    }

    public static function setUser(mixed $user): void
    {
        $_SESSION['user'] = $user;
    }

    public static function flash(string $key, mixed $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unFlash(): void
    {
        unset($_SESSION['_flash']);
    }

    public static function old(string $key, mixed $default = null)
    {
        return $_SESSION['_flash']['old'][$key] ?? $default;
    }

    public static function refresh(): void
    {
        session_regenerate_id(true);
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        session_destroy();
        setcookie('PHPSESSID', '', time() - 3600);
    }
}