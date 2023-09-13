<?php

namespace core\console;

use core\helpers\Str;

class Main
{
    public const MAP = [
        'serve' => Serve::class,
        'migrate' => Migrate::class,
    ];

    public static function run($args)
    {
        @[$commandName, $attr] = Str::split($args[1], ':', 1);

        $command = static::MAP[$commandName] ?? false;

        if ($command) {
            $attrs = [];
            if ($attr)  $attrs['command'] = $attr;

            return (new $command())->run($attrs);
        }

        echo "> Error this command '$commandName' not found";
    }
}
