<?php

namespace core\validator;

use app\exceptions\ValidationException;

class Validator extends Validation
{
    /**
     * @throws ValidationException
     */
    public static function validate(array $data, array $validation, bool $stopOnFirstError = true): array
    {
        $result = static::make($data, $validation, $stopOnFirstError);

        if (!$result) self::throw(static::$errors, $data);

        return static::$validData;
    }

    /**
     * @throws ValidationException
     */
    public static function throw(array $errors, array $data = [])
    {
        throw ValidationException::new($errors, $data);
    }

    public static function validData(): array
    {
        return static::$validData;
    }

    public static function addData(array $data): void
    {
        foreach ($data as $key => $value) {
            static::$validData[$key] = $value;
        }
    }
}