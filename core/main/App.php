<?php

namespace core\main;

use Exception;

class App
{
    protected static Container $container;

    /**
     * @param Container $container
     */
    public static function setContainer(Container $container): void
    {
        self::$container = $container;
    }

    public static function bind(string|int $key, callable $resolver): void
    {
        self::$container->bind($key, $resolver);
    }

    /**
     * @throws Exception
     */
    public static function resolver(string|int $key): mixed
    {
        return self::$container->resolve($key);
    }
}