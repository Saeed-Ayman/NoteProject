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
            if ($route->uri === $uri && $route->method === strtoupper($method)) {
                Middleware::resolve($route->middleware);

                Response::$current_route = $route;

                return Helper::controller($route->controller);
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

    public static function route(string $name): string
    {
        if (!isset(self::$names[$name]))
            Response::abort(Response::SERVER_ERROR, "'$name' not exists.");

        /**
         * @var $route Route
         */
        $route = self::$routes[self::$names[$name]];

        return $route->uri;
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
            if (isset(self::$routes[$i]->name)) {
                $oldName = self::$routes[$i]->name;
                unset(self::$names[$oldName]);
                $name .= $oldName;
            }

            self::$names[$name] = $i;
            self::$routes[$i]->name = $name;
        });

        return $this;
    }

    public function prefix(string $uri): static
    {
        self::for(self::$oldSize, count(self::$routes), function ($i) use ($uri) {
            self::$routes[$i]->uri = $uri . (self::$routes[$i]->uri ?? '');
        });

        return $this;
    }
}
