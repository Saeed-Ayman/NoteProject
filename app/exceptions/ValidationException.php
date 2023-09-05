<?php

namespace app\exceptions;

class ValidationException extends \Exception
{
    public readonly array $errors;
    public readonly array $old;

    public static function new(array $errors, array $old): static {
        $exception = new ValidationException('Un valid inputs.');

        $exception->errors = $errors;
        $exception->old = $old;

        return $exception;
    }
}