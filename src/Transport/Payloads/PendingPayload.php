<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final class PendingPayload
{
    public function __construct(
        public readonly string $api_key,
        public readonly string $project_id,
        public string $version,
        public string $sdk,
        public PendingData|Data $data,
    ) {}

    public function version(string $version): PendingPayload
    {
        $this->version = $version;

        return $this;
    }

    public function sdk(string $sdk): PendingPayload
    {
        $this->sdk = $sdk;

        return $this;
    }

    public function data(PendingData $data): PendingPayload
    {
        $this->data = $data;

        return $this;
    }

    public function build(int|float $loadtime): Payload
    {
        return new Payload(
            api_key: $this->api_key,
            project_id: $this->project_id,
            version: $this->version,
            sdk: $this->sdk,
            data: $this->data->build(),
            load_time: $loadtime,
        );
    }
}
