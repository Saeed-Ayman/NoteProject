<?php

namespace core\console;

abstract class Command
{
    public static array $commands;
    public static array $options;

    public abstract static function run(array $attr);
}
