<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport;

use Http\Discovery\Psr17FactoryDiscovery;
use JsonException;
use JustSteveKing\Sdk\Client;
use JustSteveKing\Sdk\Exceptions\ClientSetupException;
use JustSteveKing\Tools\Http\Enums\Method;
use Psr\Http\Client\ClientExceptionInterface;

class Treblle extends Client
{
    /**
     * @param array $payload
     * @return void
     * @throws JsonException|ClientSetupException|ClientExceptionInterface
     */
    public function ingress(array $payload): void
    {
        $this->setup()->send(
            request: Psr17FactoryDiscovery::findRequestFactory()->createRequest(
                method: Method::POST->value,
                uri: $this->url . '/dumps/13dba067-aaa2-4781-9452-7c58780b9aa3',
            )->withBody(
                body: Psr17FactoryDiscovery::findStreamFactory()->createStream(
                    content: (string) json_encode(
                        value: $payload,
                        flags: JSON_THROW_ON_ERROR,
                    ),
                ),
            ),
        );
    }
}
