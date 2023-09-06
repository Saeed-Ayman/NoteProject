<?php

namespace core\routes;

class Route
{
    public string $uri;
    public string $controller;
    public string $method;
    public array $middleware;
    public string|null $name;

    public function __construct(
        string $uri, string $controller, string $method, array $middleware = [], string|null $name = null)
    {
        $this->uri = $uri;
        $this->controller = $controller;
        $this->method = $method;
        $this->middleware = $middleware;
        $this->name = $name;
    }
}