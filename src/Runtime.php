<?php

declare(strict_types=1);

namespace Treblle\Runtime;

use function array_merge;

use Fiber;
use Throwable;
use Treblle\Runtime\Contracts\MaskingEngineContract;
use Treblle\Runtime\Transport\Treblle;

/**
 * @package Treblle Runtime
 * @author Steve McDougall <steve@treblle.com>
 */
class Runtime
{
    public const string VERSION = '0.0.1';

    /**
     * @param  Treblle  $transport  The HTTP Transport that is being used.
     * @param  MaskingEngineContract  $maskingEngine  // the configured masking engine
     * @param  int|float  $start  // when did this request start
     */
    public function __construct(
        public readonly Treblle $transport,
        public readonly MaskingEngineContract $maskingEngine,
        public int|float $start = 0,
        public array $data = [],
    ) {}

    /**
     * Add the request data to the payload data.
     *
     * @param array<string,mixed> $data
     * @return $this
     */
    public function request(array $data): Runtime
    {
        $this->data['request'] = array_merge(
            $this->data['request'] ?? $this->data,
            array_merge(
                $data,
                ['body' => $this->maskingEngine->mask(
                    payload: (array) $data['body'],
                    type: 'body',
                )],
                ['headers' => $this->maskingEngine->mask(
                    payload: (array) $data['headers'],
                    type: 'headers',
                )],
            ),
        );

        return $this;
    }

    /**
     * Add the response data to the payload data.
     *
     * @param array<string,mixed> $data
     * @return $this
     */
    public function response(array $data): Runtime
    {
        $this->data['response'] = array_merge(
            $this->data['response'] ?? $this->data,
            array_merge(
                $data,
                ['body' => $this->maskingEngine->mask(
                    payload: (array) $data['body'],
                    type: 'body',
                )],
                ['headers' => $this->maskingEngine->mask(
                    payload: (array) $data['headers'],
                    type: 'headers',
                )],
            ),
        );

        return $this;
    }

    /**
     * Process the payload and send through the transport.
     */
    public function process(): void
    {
        try {
            $fiber = new Fiber(
                callback: fn() => $this->send(),
            );

            $fiber->start();
        } catch (Throwable) {
        }
    }

    /**
     * Send the ingress payload through to the transport once built.
     *
     * @throws Throwable
     */
    public function send(): void
    {
        $this->transport->ingress(
            payload: array_merge(
                $this->data,
                ['load_time' => microtime(true) - $this->start],
            ),
        );
    }
}
