<?php

namespace core\routes;

use core\helpers\Helper;
use JetBrains\PhpStorm\NoReturn;

class Response
{
    const CREATED_SUCCESSFULLY = 201;
    const ACCEPTED = 202;
    const REDIRECT = 302;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const SERVER_ERROR = 500;
    public static Route $current_route;

    #[NoReturn]
    public static function abort(int $status = Response::NOT_FOUND, string $msg = ''): void
    {
        http_response_code($status);
        self::view("feedbacks.$status", compact('msg'));
        die();
    }

    public static function view(string $route, mixed $attributes = []): mixed
    {
        extract($attributes);

        $route = 'resources.views.' . $route;

        $path = str_replace('.', DIRECTORY_SEPARATOR, $route);

        return require Helper::base_path("$path.view.php");
    }
    
    #[NoReturn]
    public static function redirect(string $path, int $state = Response::REDIRECT): void
    {
        header("location: $path", response_code: $state);
        exit();
    }

    public static function previousUrl() {
        return $_SERVER['HTTP_REFERER'];
    }
}
