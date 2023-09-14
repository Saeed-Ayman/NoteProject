<?php

namespace core\database\seeder;

abstract class Seeder
{
    /**
     * Seed the application's database.
     */
    public abstract function run(): void;
}
