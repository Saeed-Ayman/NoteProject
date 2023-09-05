<?php

namespace core\routes;

use core\helpers\Helper;
use Exception;

class Router
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
        $middleware = '';
        $controller = Helper::controller($controller);
        self::$oldSize = count(self::$routes);
        self::$routes[] = compact('uri', 'controller', 'method', 'middleware');

        return self::getInstance();
    }

    public static function getInstance(): Router
    {
        if (!isset(self::$router)) self::$router = new Router();

        return self::$router;
    }

    /**
     * @throws Exception
     */
    static public function route()
    {
        [$uri, $method] = static::parseUrl();

        foreach (self::$routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                Middleware::resolve($route['middleware']);

                return require(Helper::base_path($route['controller']));
            }
        }

        Response::abort();
    }

    private static function parseUrl(): array
    {
        return [
            parse_url($_SERVER['REQUEST_URI'])['path'],
            $_POST['_method'] ?? $_SERVER['REQUEST_METHOD']
        ];
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

    //-----------------------------------------------------------------------------------------

    static public function delete(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'DELETE');
    }

    public function middleware(string $middleware): static
    {
        while (self::$oldSize != count(self::$routes)) {
            self::$routes[self::$oldSize++]['middleware'] = $middleware;
        }

        return $this;
    }
}