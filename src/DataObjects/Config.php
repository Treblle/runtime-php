<?php

declare(strict_types=1);

namespace Treblle\Runtime\DataObjects;

/**
 * @package Treblle Runtime
 * @author Steve McDougall <steve@treblle.com>
 */
final readonly class Config
{
    /**
     * @param string $api_key
     * @param string $project_id
     * @param array<int,string> $ignored_environments
     * @param array<string,mixed> $masking
     * @param array<int,string> $headers
     */
    public function __construct(
        public string $api_key,
        public string $project_id,
        public array $ignored_environments,
        public array $masking,
        public array $headers,
    ) {}
}
