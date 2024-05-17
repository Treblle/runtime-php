<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final readonly class Os
{
    /**
     * @param string $name
     * @param string $release
     * @param string $architecture
     */
    public function __construct(
        public string $name,
        public string $release,
        public string $architecture,
    ) {
    }

    /**
     * @return array{
     *     name:string,
     *     release:string,
     *     architecture:string
     * }
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'release' => $this->release,
            'architecture' => $this->architecture,
        ];
    }
}
