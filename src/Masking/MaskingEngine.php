<?php

declare(strict_types=1);

namespace Treblle\Runtime\Masking;

use RuntimeException;
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

            if ($this->shouldMask($dotNotationKey)) {
                /** @var MasksInput $maskerClass */
                $maskerClass = $this->getMaskerClass($dotNotationKey);
                if (is_array($value)) {
                    $data[$key] = $this->maskArray($value, $currentPath);
                } else {
                    $data[$key] = (new $maskerClass())->input($value)->mask();
                }
            } elseif (is_array($value)) {
                $data[$key] = $this->maskArray($value, $currentPath);
            }
        }
        return $data;
    }

    private function shouldMask(string $dotNotationKey): bool
    {
        foreach ($this->config->masking as $pattern => $maskerClass) {
            $regex = $this->convertPatternToRegex($pattern);
            if (preg_match($regex, $dotNotationKey)) {
                return true;
            }
        }
        return false;
    }

    private function getMaskerClass(string $dotNotationKey): string
    {
        foreach ($this->config->masking as $pattern => $maskerClass) {
            $regex = $this->convertPatternToRegex($pattern);
            if (preg_match($regex, $dotNotationKey)) {
                return $maskerClass;
            }
        }
        throw new \RuntimeException("No masker class found for key: $dotNotationKey");
    }

    private function convertPatternToRegex(string $pattern): string
    {
        $escapedPattern = preg_quote($pattern, '/');
        $regex = str_replace(['\*', '\.\*'], ['[^.]+', '.*'], $escapedPattern);
        return '/^' . $regex . '$/';
    }
}
