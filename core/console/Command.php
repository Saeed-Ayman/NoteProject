<?php

namespace core\console;

abstract class Command
{
    public static array $map;

    public abstract static function run(array $attr);
}
