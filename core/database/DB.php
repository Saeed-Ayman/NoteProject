<?php

namespace core\database;

use core\helpers\Str;
use core\main\App;
use Exception;

class DB
{
    /**
     * @throws Exception
     */
    public static function insert(string $table, array $attr, array $data): array|int
    {
        return App::resolver(Database::class)->query(
            "INSERT INTO $table ("
                . Str::concat($attr, ',')
                . ") VALUES ("
                . Str::concat($attr, ',', ':')
                . ")",
            $data
        )->get();
    }

    /**
     * @throws Exception
     */
    public static function update(
        string $table,
        array $attr,
        array $data,
        string $conditions,
        array $args = []
    ): array|int {
        foreach ($args as $key => $value) $data[$key] = $value;

        return App::resolver(Database::class)->query(
            "UPDATE $table"
                . " set " . Str::concat(array_map(fn ($str) => "$str = :$str", $attr), ',')
                . " WHERE $conditions",
            $data
        )->get();
    }

    /**
     * @throws Exception
     */
    public static function delete(string $table, string $conditions, array $args = []): array|int
    {
        return App::resolver(Database::class)->query(
            "DELETE FROM $table WHERE $conditions",
            $args
        )->get();
    }
}
