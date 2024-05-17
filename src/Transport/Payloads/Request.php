<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final readonly class Request
{
    /**
     * @param string $timestamp
     * @param string $ip
     * @param string $url
     * @param string $user_agent
     * @param string $method
     * @param Headers $headers
     * @param array<string,mixed>|object $body
     */
    public function __construct(
        public string $timestamp,
        public string $ip,
        public string $url,
        public string $user_agent,
        public string $method,
        public Headers $headers,
        public array|object $body,
    ) {
    }

    /**
     * @return array{
     *     timestamp:string,
     *     ip:string,
     *     user-agent:string,
     *     method:string,
     *     headers:array<string,mixed>,
     *     body:array<string,mixed>|object
     * }
     */
    public function toArray(): array
    {
        return [
            'timestamp' => $this->timestamp,
            'ip' => $this->ip,
            'url' => $this->url,
            'user-agent' => $this->user_agent,
            'method' => $this->method,
            'headers' => $this->headers->toArray(),
            'body' => $this->body,
        ];
    }
}
