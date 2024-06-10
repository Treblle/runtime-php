<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final readonly class Response
{
    /**
     * @param array<string,mixed>|object $headers
     * @param int $code
     * @param int|string $size
     * @param null|int|float $load_time
     * @param null|int|float $memory_usage
     * @param string|array<string,mixed>|object|null $body
     */
    public function __construct(
        public array|object $headers,
        public int $code,
        public int|string $size,
        public null|int|float $load_time,
        public null|int|float $memory_usage,
        public string|array|object|null $body,
    ) {}

    /**
     * @param array{
     *     headers:array|object,
     *     code:int,
     *     size:int|string,
     *     load_time:null|int|float,
     *     memory_usage:null|int|float,
     *     body:string|array|object|null,
     * } $data
     * @return Response
     */
    public static function make(array $data): Response
    {
        return new Response(
            headers: $data['headers'],
            code: $data['code'],
            size: $data['size'],
            load_time: $data['load_time'] ?? null,
            memory_usage: $data['memory_usage'] ?? null,
            body: $data['body'] ?? null,
        );
    }

    /**
     * @return array{
     *     headers:array<string,mixed>|object,
     *     code:int,
     *     size:int|string,
     *     load_time:null|int|float,
     *     memory_usage:null|int|float,
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
