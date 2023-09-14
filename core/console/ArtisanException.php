<?php

namespace core\console;

class ArtisanException extends \Exception
{
    public static function new(string $command)
    {
        $exception = new ArtisanException("> Command Error!. '$command' not found.");

        return $exception;
    }
}
