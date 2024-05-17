<?php

declare(strict_types=1);

namespace Treblle\Runtime\Contracts;

interface MaskingEngineContract
{
    public function mask(array $payload): array;
}
