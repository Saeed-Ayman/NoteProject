<?php

namespace core\routes;

use core\helpers\Helper;
use Exception;

class Router
{
    use RequestFunctions;

    static protected array $names = [];

    /**
     * @throws Exception
     */
    public static function routes()
    {
        [$uri, $method] = static::parseUrl();

        /**
         * @var $route Route
         */
        foreach (self::$routes as $route) {
            if ($route->uri === $uri && $route->method === $method) {
                Middleware::resolve($route->middleware);

                Response::$current_route = $route;

                return require(Helper::base_path($route->controller));
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

    /**
     * @throws Exception
     */
    public static function route(string $name): string
    {
        if (!isset(self::$names[$name]))
            throw new Exception('Current route not exists.');

        /**
         * @var $route Route
         */
        $route = self::$routes[self::$names[$name]];

        return $route->controller;
    }

    public static function getInstance(): Router
    {
        if (!isset(self::$router)) self::$router = new Router();

        return self::$router;
    }

    public function middleware(string ...$middleware): static
    {
        self::for(self::$oldSize, count(self::$routes), function ($i) use ($middleware) {
            if (!isset(self::$routes[$i]->middleware))
                self::$routes[$i]->middleware = [];

            array_push(self::$routes[$i]->middleware, ...$middleware);
        });

        return $this;
    }

    private
    static function for(int $start, int $end, callable $fn): void
    {
        while ($start < $end) {
            $fn($start++);
        }
    }

    public function name(string $name): static
    {
        self::for(self::$oldSize, count(self::$routes), function ($i) use ($name) {
            $oldName = '';

            if (isset($routes[$i]->name)) {
                $oldName = $routes[$i]->name;
                unset(self::$names[$oldName]);
            }

            self::$names[$oldName . $name] = $i;
            self::$routes[$i]->name = $oldName . $name;
        });

        return $this;
    }
}