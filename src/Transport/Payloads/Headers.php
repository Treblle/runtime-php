<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final readonly class Headers
{
    /**
     * @param string $content_type
     * @param int|float|string $content_length
     * @param string $host
     * @param string $user_agent
     */
    public function __construct(
        public string $content_type,
        public int|float|string $content_length,
        public string $host,
        public string $user_agent,
    ) {}

    /**
     * @param array{
     *     content_type:string,
     *     content_length:int|float|string,
     *     host:string,
     *     user_agent:string,
     * } $data
     * @return Headers
     */
    public static function make(array $data): Headers
    {
        return new Headers(
            content_type: $data['content_type'],
            content_length: $data['content_length'],
            host: $data['host'],
            user_agent: $data['user_agent'],
        );
    }

    /**
     * @return array{
     *     content-type:string,
     *     content-length:string|int|float,
     *     host:string,
     *     user-agent:string
     * }
     */
    public function toArray(): array
    {
        return [
            'content-type' => $this->content_type,
            'content-length' => $this->content_length,
            'host' => $this->host,
            'user-agent' => $this->user_agent,
        ];
    }
}
