<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport;

use DateTimeImmutable;
use DateTimeInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use JsonException;
use JustSteveKing\Sdk\Client;
use JustSteveKing\Sdk\Exceptions\ClientSetupException;
use JustSteveKing\Tools\Http\Enums\Method;
use Psr\Http\Client\ClientExceptionInterface;
use Treblle\CloudEvent\CloudEvent;
use Treblle\Runtime\Transport\Payloads\Payload;

final class Treblle extends Client
{
    /**
     * @param Payload $payload
     * @return void
     * @throws JsonException|ClientSetupException|ClientExceptionInterface
     */
    public function ingress(Payload $payload): void
    {
        $this->setup()->send(
            request: Psr17FactoryDiscovery::findRequestFactory()->createRequest(
                method: Method::POST->value,
                uri: $this->url . '/dumps/2d4445d8-4238-4a3e-9559-89248248f57b',
            )->withBody(
                body: CloudEvent::make(
                    data: [
                        'id' => '1234',
                        'source' => 'current-url',
                        'type' => 'com.treblle.observability.ingress',
                        'data' => (string) json_encode(
                            value: $payload->toArray(),
                            flags: JSON_THROW_ON_ERROR,
                        ),
                        'data_content_type' => 'application/json',
                        'data_schema' => 'create-json-schema',
                        'subject' => 'treblle-ingress',
                        'time' => (new DateTimeImmutable(
                            datetime: 'now',
                        ))->format(DateTimeInterface::RFC3339),
                    ],
                )->toStream(),
            ),
        );
    }
}
