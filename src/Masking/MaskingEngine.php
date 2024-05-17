<?php

declare(strict_types=1);

namespace Treblle\Runtime\Masking;

use Treblle\Runtime\Contracts\MaskingEngineContract;
use Treblle\Runtime\Contracts\MasksInput;
use Treblle\Runtime\DataObjects\Config;

final readonly class MaskingEngine implements MaskingEngineContract
{
    public function __construct(
        private Config $config,
    ) {}

    public function mask(array $payload): array
    {
        return $this->maskArray($payload, []);
    }

    private function maskArray(array $data, array $path): array
    {
        foreach ($data as $key => $value) {
            $currentPath = array_merge($path, [$key]);
            $dotNotationKey = implode('.', $currentPath);

            if (isset($this->config->masking[$dotNotationKey])) {
                /** @var MasksInput $maskerClass */
                $maskerClass = $this->config->masking[$dotNotationKey];
                $data[$key] = (new $maskerClass())->input($value)->mask();
            } elseif (is_array($value)) {
                $data[$key] = $this->maskArray($value, $currentPath);
            }
        }
        return $data;
    }
}
