<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final readonly class Os
{
    /**
     * @param string $name
     * @param string $host
     * @param string $version
     * @param string $release
     * @param string $architecture
     */
    public function __construct(
        public string $name,
        public string $host,
        public string $version,
        public string $release,
        public string $architecture,
    ) {}

    /**
     * @param array{
     *     name:string,
     *     host:string,
     *     version:string,
     *     release:string,
     *     architecture:string,
     * } $data
     * @return Os
     */
    public static function make(array $data): Os
    {
        return new Os(
            name: $data['name'],
            host: $data['host'],
            version: $data['version'],
            release: $data['release'],
            architecture: $data['architecture'],
        );
    }

    /**
     * @return array{
     *     name:string,
     *     host:string,
     *     version:string,
     *     release:string,
     *     architecture:string
     * }
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'host' => $this->host,
            'version' => $this->version,
            'release' => $this->release,
            'architecture' => $this->architecture,
        ];
    }
}
