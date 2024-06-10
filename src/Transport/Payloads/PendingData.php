<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final class PendingData
{
    public function __construct(
        public null|Server $server = null,
        public null|Language $language = null,
        public null|Request $request = null,
        public null|Response $response = null,
        public array $errors = [],
    ) {}

    public function server(Server $server): PendingData
    {
        $this->server = $server;

        return $this;
    }

    public function language(Language $language): PendingData
    {
        $this->language = $language;

        return $this;
    }

    public function request(Request $request): PendingData
    {
        $this->request = $request;

        return $this;
    }

    public function response(Response $response): PendingData
    {
        $this->response = $response;

        return $this;
    }

    public function errors(array $errors): PendingData
    {
        $this->errors = $errors;

        return $this;
    }

    public function build(): Data
    {
        return new Data(
            server: $this->server,
            language: $this->language,
            request: $this->request,
            response: $this->response,
            errors: $this->errors,
        );
    }
}
