<?php

namespace core\routes;

use app\http\middleware\{Auth, Guest};
use Exception;

class Middleware
{
    public const MAP = [
        'auth' => Auth::class,
        'guest' => Guest::class,
    ];

    /**
     * @throws Exception
     */
    public static function resolve(array $keys): void
    {
        if (!$keys) return;

        $middlewares = [];
        foreach ($keys as $key) {
            $middleware = static::MAP[$key] ?? false;

            if (!$middleware) {
                throw new Exception("No matching middleware found for key '$key'.");
            }

            $middlewares[] = fn($next) => (new $middleware())->handle($next);
        }
        new Closure($middlewares);
    }
}