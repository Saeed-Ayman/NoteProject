<?php

namespace core\console;

class ArtisanException extends \Exception
{
    public static function new(string $command, string|null $subCommand)
    {
        $exception = new ArtisanException("> Command Error!. '$command:$subCommand' not found.");

        return $exception;
    }
}
