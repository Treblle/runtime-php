<?php

declare(strict_types=1);

namespace Treblle\Runtime;

use Fiber;
use Treblle\Runtime\Contracts\MaskingEngineContract;
use Treblle\Runtime\Transport\Payloads\Payload;
use Treblle\Runtime\Transport\Treblle;

final class Runtime
{
    public const string VERSION = '0.0.1';

    public function __construct(
        private readonly Treblle $transport,
        private readonly MaskingEngineContract $maskingEngine,
    ) {}

    public function process(array $data): void
    {
        $maskedData = $this->maskingEngine->mask(
            payload: $data,
        );

        // send to API
        $fiber = new Fiber(
            callback: fn () => $this->send(
                payload: $maskedData,
            ),
        );

        $fiber->start();
    }

    public function send(array $payload): void
    {
        $this->transport->ingress(
            payload: Payload::make(
                data: array_merge(
                    $payload,
                    [
                        'api_key' => ''
                    ]
                ),
            ),
        );
    }
}
