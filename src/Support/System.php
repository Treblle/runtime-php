<?php

declare(strict_types=1);

namespace Treblle\Runtime\Support;

use function php_uname;

final class System
{
    public static function ip(): string
    {
        return self::fromGlobal(
            global: $_SERVER,
            arg: 'SERVER_ADDR',
        );
    }

    public static function timezone(): string
    {
        return date_default_timezone_get();
    }

    public static function software(): string
    {
        return self::fromGlobal(
            global: $_SERVER,
            arg: 'SERVER_SOFTWARE',
        );
    }

    public static function signature(): string
    {
        return self::fromGlobal(
            global: $_SERVER,
            arg: 'SERVER_SIGNATURE',
        );
    }

    public static function protocol(): string
    {
        return self::fromGlobal(
            global: $_SERVER,
            arg: 'SERVER_PROTOCOL',
        );
    }

    public static function encoding(): string
    {
        return self::fromGlobal(
            global: $_SERVER,
            arg: 'HTTP_ACCEPT_ENCODING',
        );
    }

    public static function name(): string
    {
        return PHP_OS;
    }

    public static function host(): string
    {
        return php_uname('n');
    }

    public static function release(): string
    {
        return php_uname('r');
    }

    public static function architecture(): string
    {
        return php_uname('m');
    }

    public static function version(): string
    {
        return php_uname('v');
    }

    public static function fromGlobal(array $global, string $arg): string
    {
        return $global[$arg] ?? '<unknown>';
    }
}
