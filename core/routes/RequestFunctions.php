<?php

namespace core\routes;

trait RequestFunctions
{
    static protected array $routes = [];
    static protected int $oldSize = 0;
    static protected Router $router;

    public static function put(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'PUT');
    }

    static private function add(string $uri, string $controller, string $method): Router
    {
        self::$oldSize = count(self::$routes);
        self::$routes[] = new Route($uri, $controller, $method);

        return self::getInstance();
    }

    /**
     * @param string $name
     * @param string|null $controller if null then $controller = $name
     * @return Router
     */
    public static function resource(string $name, string|null $controller = null): Router
    {
        $n = count(self::$routes);

        if (!$controller) $controller = $name;

        Router::get("/{$name}s", "$controller.index")->name("{$name}s.index");
        Router::get("/$name/create", "$controller.create")->name("{$name}s.create");
        Router::post("/$name", "$controller.store")->name("{$name}s.store");
        Router::get("/$name", "$controller.show")->name("{$name}s.show");
        Router::get("/$name/edit", "$controller.edit")->name("{$name}s.edit");
        Router::patch("/$name", "$controller.update")->name("{$name}s.update");
        Router::delete("/$name", "$controller.destroy")->name("{$name}s.destroy");

        self::$oldSize = $n;

        return self::$router;
    }

    public static function get(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'GET');
    }

    public static function post(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'POST');
    }

    public static function patch(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'PATCH');
    }

    public static function delete(string $uri, string $controller): Router
    {
        return self::add($uri, $controller, 'DELETE');
    }

    public static function group(callable $fn): Router
    {
        $n = count(self::$routes);

        $fn();

        self::$oldSize = $n;

        return self::$router;
    }
}
