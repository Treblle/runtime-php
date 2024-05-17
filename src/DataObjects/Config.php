<?php

declare(strict_types=1);

namespace Treblle\Runtime\DataObjects;

final readonly class Config
{
    /**
     * @param string $api_key
     * @param string $project_id
     * @param array<int,string> $ignored_environments
     * @param array<string,mixed> $masking
     */
    public function __construct(
        public string $api_key,
        public string $project_id,
        public array $ignored_environments,
        public array $masking,
    ) {}
}
