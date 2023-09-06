<?php

namespace core\routes;

use core\helpers\Helper;

trait RequestFunctions
{
    static protected array $routes = [];
    static protected int $oldSize = 0;
    static protected Router $router;

    static public function put(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'PUT');
    }

    static private function add(string $uri, string $controller, string $method): Router
    {
        self::$oldSize = count(self::$routes);
        self::$routes[] = new Route($uri, Helper::controller($controller), $method);

        return self::getInstance();
    }

    public static function resource(string $uri, string $controller): Router
    {
        $n = count(self::$routes);

        Router::get($uri . 's', $controller . '.index');
        Router::get($uri . 's/create', $controller . '.create');
        Router::post($uri . 's/create', $controller . '.create');
        Router::post($uri . 's', $controller . '.store');
        Router::get($uri, $controller . '.show');
        Router::get($uri . '/edit', $controller . '.edit');
        Router::patch($uri . 's', $controller . '.update');
        Router::delete($uri, $controller . '.destroy');

        self::$oldSize = $n;

        return self::$router;
    }

    static public function get(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'GET');
    }

    static public function post(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'POST');
    }

    static public function patch(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'PATCH');
    }

    static public function delete(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'DELETE');
    }
}