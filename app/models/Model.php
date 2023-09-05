<?php

namespace app\models;

use core\database\DB;
use core\database\QueryBuilder;
use Exception;

class Model
{
    protected static string $table = '';
    protected static array $fillable = [];
    protected static array $hashed = [];

    /**
     * @throws Exception
     */
    public static function create(array $data): array|int
    {
        foreach (static::$hashed as $hash) {
            $data[$hash] = self::hash($data[$hash]);
        }

        return DB::insert(static::$table, static::$fillable, $data);
    }

    private static function hash(mixed $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @throws Exception
     */
    public static function update(array $data, string $conditions, array $args = []): bool
    {
        foreach (static::$hashed as $hash) {
            if (isset($data[$hash])) $data[$hash] = self::hash($data[$hash]);
        }

        $fillable = [];

        foreach ($data as $key => $value) {
            if (in_array($key, static::$fillable)) $fillable[] = $key;
        }

        return DB::update(static::$table, $fillable, $data, $conditions, $args);
    }


    /**
     * @throws Exception
     */
    public static function delete(string $condition, array $args = []): bool
    {
        return DB::delete(static::$table, $condition, $args);
    }

    // ------------------------------------------------------------------------------

    public static function all(array $attr = []): QueryBuilder
    {
        return static::getBuilder()->all($attr);
    }

    private static function getBuilder(): QueryBuilder
    {
        return new QueryBuilder(static::$table);
    }

    public static function where(string $conditions, array $args = []): QueryBuilder
    {
        return static::getBuilder()->where($conditions, $args);
    }

    public function orderBy(string $column, bool $asc = true): QueryBuilder
    {
        return static::getBuilder()->orderBy($column, $asc);
    }

    // ----------------------------------------------------------

    public function limit(int $limit): QueryBuilder
    {
        return static::getBuilder()->limit($limit);
    }

    // ----------------------------------------------------------

    public function offset(int $offset): QueryBuilder
    {
        return static::getBuilder()->offset($offset);
    }
}