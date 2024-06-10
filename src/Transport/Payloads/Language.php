<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final readonly class Language
{
    /**
     * @param string $name
     * @param string $version
     * @param string $expose_php
     * @param string $display_errors
     */
    public function __construct(
        public string $name,
        public string $version,
        public string $expose_php,
        public string $display_errors,
    ) {}

    /**
     * @param array{
     *     name:string,
     *     version:string,
     *     expose_php:string,
     *     display_errors:string,
     * } $data
     * @return Language
     */
    public static function make(array $data): Language
    {
        return new Language(
            name: $data['name'],
            version: $data['version'],
            expose_php: $data['expose_php'],
            display_errors: $data['display_errors'],
        );
    }

    /**
     * @return array{
     *     name:string,
     *     version:string,
     *     expose_php:string,
     *     display_errors:string
     * }
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'version' => $this->version,
            'expose_php' => $this->expose_php,
            'display_errors' => $this->display_errors,
        ];
    }
}
