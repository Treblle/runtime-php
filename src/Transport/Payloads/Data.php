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
    ) {}

    /**
     * @param array{
     *     server:array,
     *     language:array,
     *     request:array,
     *     response:array,
     *     errors:null|array
     * } $data
     * @return Data
     */
    public static function make(array $data): Data
    {
        return new Data(
            server: Server::make(
                data: $data['server'],
            ),
            language: Language::make(
                data: $data['language'],
            ),
            request: Request::make(
                data: $data['request'],
            ),
            response: Response::make(
                data: $data['response'],
            ),
            errors: $data['errors'] ? array_map(
                callback: static fn(array $error): Error => Error::make(
                    data: $error,
                ),
                array: $data['errors'],
            ) : [],
        );
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
                callback: static fn(Error $error): array => $error->toArray(),
                array: $this->errors,
            ),
        ];
    }
}
