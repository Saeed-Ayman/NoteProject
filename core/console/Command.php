<?php

namespace core\console;

abstract class Command
{
    public string $category;
    public string $description;

    public abstract static function run(array $attr);
}
