<?php

namespace core\database\migration;

use core\database\Database;
use core\helpers\Str;
use core\main\App;

class Schema
{
    public static function create(string $tableName, callable $fn): void
    {
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

        /**
         * @var Database $db
         */
        $db = App::resolver(Database::class);
        $db->query($query)->get();
    }

    public static function drop($tableName): void
    {
        /**
         * @var Database $db
         */
        $db = App::resolver(Database::class);
        $db->query("DROP TABLE IF EXISTS $tableName")->get();
    }
}
