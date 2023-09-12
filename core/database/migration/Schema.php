<?php

namespace core\database\migration;

use core\database\Database;
use core\helpers\Helper;
use core\helpers\Str;

class Schema
{
    public static function create(string $tableName, callable $fn): void
    {
        echo "> Creating table $tableName\n";

        $fn($blueprint = new Blueprint);

        $prepareQuery = [];
        foreach ($blueprint->columns as $column => $attr) {
            $prepareQuery[] = $column . ' ' . Str::concat($attr, ' ');
        }

        foreach ($blueprint->forginId as $column => [$table, $refColumn]) {
            $prepareQuery[] = "FOREIGN KEY ($column) REFERENCES $table($refColumn)";
        }

        $query = "CREATE TABLE IF NOT EXISTS $tableName  (";
        $query .= Str::concat($prepareQuery, ', ');
        $query .= ");";

        $config = require(Helper::base_path('config\database.php'));
        $a = (new Database($config))->query($query)->get();

        echo "> Created table $tableName successfully\n";
    }

    public static function drop($tableName): void
    {
        echo "> Droping table $tableName\n";
        // DROP [TEMPORARY] TABLE [IF EXISTS] table_name 
        $config = require(Helper::base_path('config\database.php'));
        (new Database($config))->query("DROP TABLE IF EXISTS $tableName")->get();
        echo "> Drop table $tableName successfully\n";
    }
}
