<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final readonly class Data
{
    /**
     * @param Server $server
     * @param Language $language
     * @param Request $request
     * @param Response $response
     * @param array<int,Error> $errors
     */
    public function __construct(
        public Server $server,
        public Language $language,
        public Request $request,
        public Response $response,
        public array $errors,
    ) {
    }

    /**
     * @return array{
     *     server:array<string,mixed>,
     *     language:array<string,mixed>,
     *     request:array<string,mixed>,
     *     response:array<string,mixed>,
     *     errors:array<int,mixed>
     * }
     */
    public function toArray(): array
    {
        return [
            'server' => $this->server->toArray(),
            'language' => $this->language->toArray(),
            'request' => $this->request->toArray(),
            'response' => $this->response->toArray(),
            'errors' => array_map(
                callback: static fn (Error $error): array => $error->toArray(),
                array: $this->errors,
            ),
        ];
    }
}
