<?php

namespace core\helpers;

class Str
{
    public static function split(string|null $string, string $separator = ' ', int $count = -1): array
    {
        $strings = [];

        while ($string && $count--) {
            $position = strpos($string, $separator);

            if (!$position) break;

            $strings[] = substr($string, 0, $position);
            $string = substr($string, $position + strlen($separator));
        }

        $strings[] = $string;
        return $strings;
    }

    public static function concat(array $strings, string $separator = '', string $additionalString = ''): string
    {
        if (empty($strings)) return '';

        $string = $additionalString . $strings[0];

        for ($i = 1; $i < count($strings); $i++) {
            $string .= $separator . $additionalString . $strings[$i];
        }

        return $string;
    }
}