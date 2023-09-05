<?php

namespace core\validator;

use core\database\Database;
use core\main\App;
use Exception;

trait ValidateFunctions
{
    public static function require($data): bool
    {
        return !empty($data);
    }

    public static function between($data, float $min = -INF, float $max = INF): bool
    {
        return self::min($data, $min) && self::max($data, $max);
    }

    public static function min($data, float $number = -INF): bool
    {
        return
            (is_array($data) && count($data) >= $number) ||
            (is_string($data) && strlen($data) >= $number) ||
            (is_numeric($data) && $number != 0 && $data >= $number);
    }

    public static function max($data, float $number = INF): bool
    {
        return
            (is_array($data) && count($data) <= $number) ||
            (is_string($data) && strlen($data) <= $number) ||
            (is_numeric($data) && $number != 0 && $data <= $number);
    }

    public static function email(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function password(string $password): bool
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChar = preg_match('@\W@', $password);

        return $uppercase && $lowercase && $number && $specialChar;
    }

    public static function username(string $username): bool|int
    {
        return preg_match('/^[a-z_][a-z_0-9\-.]+$/', $username);
    }

    public static function ascii(string $string): bool|int
    {
        return preg_match('/^[A-Za-z]+$/', $string);
    }

    public static function ascii_space(string $string): bool|int
    {
        return preg_match('/^[A-Za-z ]+$/', $string);
    }

    public static function ascii_number(string $string): bool|int
    {
        return preg_match('/^[A-Za-z 0-9]+$/', $string);
    }

    /**
     * @throws Exception
     */
    public static function unique(string $data, string $table, string $column): bool
    {
        $db = App::resolver(Database::class);

        $result = $db->query(
            "SELECT * FROM $table WHERE $column = :data",
            ['data' => $data]
        )->get();

        return empty($result);
    }
}