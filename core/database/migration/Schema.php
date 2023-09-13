<?php

namespace core\database\migration;

use core\console\Migrate;
use core\helpers\Str;

class Schema
{
    public static function create(string $tableName, callable $fn): void
    {
        echo "> Creating table $tableName.\n";

        $fn($blueprint = new Blueprint);

        $prepareQuery = [];
        foreach ($blueprint->columns as $column => $attr) {
            $prepareQuery[] = $column . ' ' . Str::concat($attr, ' ');
        }

        foreach ($blueprint->foreignId as $column => [$table, $refColumn]) {
            $prepareQuery[] = "FOREIGN KEY ($column) REFERENCES $table($refColumn)";
        }

        $query = "CREATE TABLE IF NOT EXISTS $tableName  (";
        $query .= Str::concat($prepareQuery, ', ');
        $query .= ");";

        Migrate::$db->query($query)->get();
    }

    public static function drop($tableName): void
    {
        echo "> Dropping table $tableName.\n";
        Migrate::$db->query("DROP TABLE IF EXISTS $tableName")->get();
    }
}
