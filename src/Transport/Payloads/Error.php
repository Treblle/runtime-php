<?php

declare(strict_types=1);

namespace Treblle\Runtime\Transport\Payloads;

final readonly class Error
{
    /**
     * @param string $source
     * @param string $type
     * @param string $message
     * @param string $file
     * @param int $line
     */
    public function __construct(
        public string $source,
        public string $type,
        public string $message,
        public string $file,
        public int $line,
    ) {}

    /**
     * @param array{
     *     source:string,
     *     type:string,
     *     message:string,
     *     file:string,
     *     line:int,
     * } $data
     * @return Error
     */
    public static function make(array $data): Error
    {
        return new Error(
            source: $data['source'],
            type: $data['type'],
            message: $data['message'],
            file: $data['file'],
            line: $data['line'],
        );
    }

    /**
     * @return array{
     *     source:string,
     *     type:string,
     *     message:string,
     *     file:string,
     *     line:int
     * }
     */
    public function toArray(): array
    {
        return [
            'source' => $this->source,
            'type' => $this->type,
            'message' => $this->message,
            'file' => $this->file,
            'line' => $this->line,
        ];
    }
}
