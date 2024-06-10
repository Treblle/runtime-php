<?php

declare(strict_types=1);

namespace Treblle\Runtime\Support;

use function is_bool;

use Throwable;

use Treblle\Runtime\Transport\Payloads\Language;

final class PHP
{
    public static function name(): string
    {
        return 'php';
    }

    public static function version(): string
    {
        return PHP_VERSION;
    }

    public static function exposePHP(): string
    {
        return self::ini(
            arg: 'expose_php',
        );
    }

    public static function displayErrors(): string
    {
        return self::ini(
            arg: 'display_errors',
        );
    }

    public static function language(): Language
    {
        return new Language(
            name: self::name(),
            version: self::version(),
            expose_php: self::exposePHP(),
            display_errors: self::displayErrors(),
        );
    }

    public static function ini(string $arg): string
    {
        try {
            $variableValue = \safe\ini_get(
                option: $arg,
            );
            $isBool = filter_var(
                value: $variableValue,
                filter: FILTER_VALIDATE_BOOLEAN,
                options: FILTER_NULL_ON_FAILURE,
            );

            if (is_bool($isBool)) {
                return ('' !== $variableValue && '0' !== $variableValue) ? 'On' : 'Off';
            }

            return $variableValue;
        } catch (Throwable) {
        }

        return '<unknown>';
    }
}
