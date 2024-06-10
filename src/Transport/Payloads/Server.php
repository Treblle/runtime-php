<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final readonly class Server
{
    /**
     * @param string $ip
     * @param string $timezone
     * @param Os $os
     * @param string|null $software
     * @param string|null $signature
     * @param string $protocol
     * @param string $encoding
     */
    public function __construct(
        public string $ip,
        public string $timezone,
        public Os $os,
        public string|null $software,
        public string|null $signature,
        public string $protocol,
        public string $encoding,
    ) {}

    /**
     * @param array{
     *     ip:string,
     *     timezone:string,
     *     os:array,
     *     software:null|string,
     *     signature:null|string,
     *     protocol:string,
     *     encoding:string,
     * } $data
     * @return Server
     */
    public static function make(array $data): Server
    {
        return new Server(
            ip: $data['ip'],
            timezone: $data['timezone'],
            os: Os::make(
                data: $data['os'],
            ),
            software: $data['software'],
            signature: $data['signature'],
            protocol: $data['protocol'],
            encoding: $data['encoding'],
        );
    }

    /**
     * @return array{
     *     ip:string,
     *     timezone:string,
     *     os:array{
     *      name:string,
     *      release:string,
     *      architecture:string
     *     },
     *     software:string|null,
     *     signature:string|null,
     *     protocol:string,
     *     encoding:string
     * }
     */
    public function toArray(): array
    {
        return [
            'ip' => $this->ip,
            'timezone' => $this->timezone,
            'os' => $this->os->toArray(),
            'software' => $this->software,
            'signature' => $this->signature,
            'protocol' => $this->protocol,
            'encoding' => $this->encoding,
        ];
    }
}
