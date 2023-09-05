<?php

namespace core\main;

use Exception;

class Container
{
    protected array $bindings = [];

    public function bind(string|int $key, callable $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    /**
     * @throws Exception
     */
    public function resolve(string|int $key): mixed
    {
        if (!array_key_exists($key, $this->bindings)) {
            throw new Exception("No matching binding found for this key '$key'");
        }

        return call_user_func($this->bindings[$key]);
    }
}