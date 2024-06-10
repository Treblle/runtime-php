<?php

declare(strict_types=1);

namespace Treblle\Runtime;

use function array_merge;

use Fiber;
use Http\Message\Authentication\Header;

use Throwable;

use Treblle\Runtime\Contracts\MaskingEngineContract;
use Treblle\Runtime\DataObjects\Config;
use Treblle\Runtime\Support\PHP;
use Treblle\Runtime\Support\System;
use Treblle\Runtime\Transport\Payloads\PendingData;
use Treblle\Runtime\Transport\Payloads\PendingPayload;
use Treblle\Runtime\Transport\Payloads\Request;
use Treblle\Runtime\Transport\Payloads\Response;
use Treblle\Runtime\Transport\Treblle;

final class Runtime
{
    public const string VERSION = '0.0.1';

    /**
     * @param Treblle $transport The HTTP Transport that is being used.
     * @param PendingPayload $payload // the Pending Payload for ingress
     * @param MaskingEngineContract $maskingEngine // the configured masking engine
     * @param int|float $start // when did this request start
     */
    public function __construct(
        private readonly Treblle $transport,
        private readonly PendingPayload $payload,
        private readonly MaskingEngineContract $maskingEngine,
        public int|float $start = 0,
    ) {}

    /**
     * Create a new pending payload
     *
     * @param Config $config
     * @return PendingPayload
     */
    public static function payload(Config $config): PendingPayload
    {
        return new PendingPayload(
            api_key: $config->api_key,
            project_id: $config->project_id,
            version: self::VERSION,
            sdk: 'php',
            data: new PendingData(
                server: System::server(),
                language: PHP::language(),
            ),
        );
    }

    /**
     * Add the request data to the payload data.
     *
     * @param array{
     *     timestamp:string,
     *     ip:string,
     *     url:string,
     *     user_agent:string,
     *     method:string,
     *     headers:Header,
     *     body:array<string,mixed>|object
     * } $data
     * @return $this
     */
    public function request(array $data): Runtime
    {
        if (null !== $this->payload->data) {
            $this->payload->data = $this->payload->data?->request(
                request: Request::make(
                    data: array_merge(
                        $data,
                        ['body' => $this->maskingEngine->mask(
                            payload: $data['body'],
                        )],
                    ),
                ),
            );
        }

        return $this;
    }

    /**
     * Add the response data to the payload data.
     *
     * @param array{
     *     headers:array,
     *     code:int,
     *     size:int|string,
     *     load_time:null|int|float,
     *     memory_usage:null|int|float,
     *     body:string|array|object|null,
     * } $data
     * @return $this
     */
    public function response(array $data): Runtime
    {
        if (null !== $this->payload->data) {
            $this->payload->data = $this->payload->data->response(
                response: Response::make(
                    data: array_merge(
                        $data,
                        ['body' => $this->maskingEngine->mask(
                            payload: $data['body'],
                        )],
                    ),
                ),
            );
        }

        return $this;
    }

    /**
     * Process the payload and send through the transport.
     *
     * @return void
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
     * @return void
     * @throws Throwable
     */
    public function send(): void
    {
        $this->transport->ingress(
            payload: $this->payload->build(
                loadtime: microtime(true) - $this->start,
            ),
        );
    }
}
