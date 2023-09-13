<?php

namespace core\console;

class Serve extends Command
{
    public static function run(array $attr)
    {
        $port = $attr['port'] ?? $attr['p'] ?? 8888;

        exec("php -S localhost:$port -t public");
    }
}
