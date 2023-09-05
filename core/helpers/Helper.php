<?php

namespace core\helpers;

use JetBrains\PhpStorm\NoReturn;

class Helper
{
    #[NoReturn]
    public static function dd(mixed ...$values): void
    {
        foreach ($values as $value) {
            echo '<pre>';
            var_dump($value);
            echo '</pre>';
            echo '<br />';
        }
        die();
    }

    public static function urlIs(string $url): bool
    {
        $path = parse_url($_SERVER['REQUEST_URI'])['path'];
        return $path === $url;
    }

    public static function base_path(string $path): string
    {
        return BASE_PATH . $path;
    }

    public static function controller(string $controller): string
    {
        $controller = 'app.http.controllers.' . $controller;

        $path = str_replace('.', DIRECTORY_SEPARATOR, $controller);

        return "$path.php";
    }

    public static function isAuth()
    {
        return $_SESSION['user'] ?? false;
    }
}