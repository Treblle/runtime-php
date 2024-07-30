<?php

declare(strict_types=1);

namespace Treblle\Runtime\Factories;

use Treblle\Runtime\DataObjects\Config;

final class ConfigFactory
{
    /**
     * @param array{
     *     api_key:string,
     *     project_id:string,
     *     ignored_environments:array<int,string>,
     *     masking:array<string,mixed>,
     *     headers:array<int,string>,
     * } $config
     * @return Config
     */
    public static function make(array $config): Config
    {
        return new Config(
            api_key: $config['api_key'],
            project_id: $config['project_id'],
            ignored_environments: $config['ignored_environments'],
            masking: $config['masking'],
            headers: $config['headers'],
        );
    }
}
