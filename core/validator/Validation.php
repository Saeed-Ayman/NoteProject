<?php

namespace core\validator;

use core\helpers\Helper;
use core\helpers\Str;

class Validation
{
    use ValidateFunctions;

    protected static array $validData, $errors;

    public static function make(array $data, array $validation, bool $stopOnFirstError = true): bool
    {
        self::$validData = [];
        self::$errors = [];
        $validationMessages = Helper::require('config\validation.php');

        foreach ($validation as $key => $value) {
            if (is_string($data[$key])) $data[$key] = trim(htmlspecialchars($data[$key]));

            if (!$value) continue;

            $rules = is_string($value) ? str::split($value, '|') : $value;

            foreach ($rules as $rule) {
                @[$func, $args] = Str::split($rule, ':', 1);
                $args = Str::split($args, ',');

                if (!self::$func($data[$key], ...$args)) {
                    if ($stopOnFirstError) {
                        self::$errors[$key] = $validationMessages[$func];
                        break;
                    }
                    self::$errors[$key][$func] = $validationMessages[$func];
                }
            }

            if (!isset(self::$errors[$key])) self::$validData[$key] = $data[$key];
        }

        return empty(self::$errors);
    }
}