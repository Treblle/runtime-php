<?php

declare(strict_types=1);

namespace Treblle\Runtime\Masking;

final class SocialSecurityMatcher extends StringMatcher
{
    protected string $pattern = '/^\d{3}-\d{2}-\d{4}$/';

    public function mask(): string
    {
        return (string) preg_replace(
            pattern: '/^(\d{3}-\d{2}-)(\d{4})$/',
            replacement: '***-**-$2',
            subject: $this->input,
        );
    }
}
