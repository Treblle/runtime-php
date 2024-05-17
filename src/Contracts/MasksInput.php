<?php

declare(strict_types=1);

namespace Treblle\Runtime\Contracts;

interface MasksInput
{
    public function input(string $input): MasksInput;

    public function mask(): string;
}
