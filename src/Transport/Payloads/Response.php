<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final readonly class Response
{
    /**
     * @param array<string,mixed>|object $headers
     * @param int $code
     * @param int|string $size
     * @param int|float $load_time
     * @param int|float $memory_usage
     * @param string|array<string,mixed>|object|null $body
     */
    public function __construct(
        public array|object $headers,
        public int $code,
        public int|string $size,
        public int|float $load_time,
        public int|float $memory_usage,
        public string|array|object|null $body,
    ) {
    }

    /**
     * @return array{
     *     headers:array<string,mixed>|object,
     *     code:int,
     *     size:int|string,
     *     load_time:int|float,
     *     memory_usage:int|float,
     *     body:string|array<string,mixed>|object|null
     * }
     */
    public function toArray(): array
    {
        return [
            'headers' => $this->headers,
            'code' => $this->code,
            'size' => $this->size,
            'load_time' => $this->load_time,
            'memory_usage' => $this->memory_usage,
            'body' => $this->body,
        ];
    }
}
