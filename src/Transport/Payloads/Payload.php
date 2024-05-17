<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\StreamInterface;

final readonly class Payload
{
    /**
     * @param string $api_key
     * @param string $project_id
     * @param string $version
     * @param string $sdk
     * @param Data $data
     */
    public function __construct(
        public string $api_key,
        public string $project_id,
        public string $version,
        public string $sdk,
        public Data $data,
    ) {
    }

    /**
     * @param array{
     *      api_key: string,
     *      project_id: string,
     *      version:string,
     *      sdk:string,
     *      data:array<string,mixed>
     *  } $data
     * @return Payload
     */
    public static function make(array $data): Payload
    {
        return new Payload(
            api_key: $data['api_key'],
            project_id: $data['project_id'],
            version: $data['version'],
            sdk: $data['sdk'],
            data: $data['data'],
        );
    }

    /**
     * @return array{
     *     api_key: string,
     *     project_id: string,
     *     version:string,
     *     sdk:string,
     *     data:array<string,mixed>
     * }
     */
    public function toArray(): array
    {
        return [
            'api_key' => $this->api_key,
            'project_id' => $this->project_id,
            'version' => $this->version,
            'sdk' => $this->sdk,
            'data' => $this->data->toArray(),
        ];
    }

    public function toStream(): StreamInterface
    {
        return Psr17FactoryDiscovery::findStreamFactory()->createStream(
            content: (string) json_encode(
                value: $this->toArray(),
                flags: JSON_THROW_ON_ERROR,
            ),
        );
    }
}
