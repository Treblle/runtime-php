<?php

declare(strict_types=1);

namespace Treblle\Runtime\Masking;

use Treblle\Runtime\Contracts\MasksInput;

class StringMatcher implements MasksInput
{
    protected string $pattern;

    protected string $input;

    public function input(string $input): StringMatcher
    {
        $this->input = $input;

        return $this;
    }

    /** @return bool */
    public function match(): bool
    {
        return 1 === preg_match(
            $this->pattern,
            $this->input,
        );
    }

    /** @return string */
    public function mask(): string
    {
        return (string) preg_replace(
            pattern: '/./s',
            replacement: '*',
            subject: $this->input,
        );
    }
}
