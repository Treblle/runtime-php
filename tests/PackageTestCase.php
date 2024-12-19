<?php

declare(strict_types=1);

namespace Treblle\Runtime\Tests;

use PHPUnit\Framework\TestCase;
use Treblle\Runtime\DataObjects\Config;
use Treblle\Runtime\Masking\CreditCardMatcher;
use Treblle\Runtime\Masking\DateMatcher;
use Treblle\Runtime\Masking\EmailMatcher;
use Treblle\Runtime\Masking\MaskingEngine;
use Treblle\Runtime\Masking\PostalCodeMatcher;
use Treblle\Runtime\Masking\SocialSecurityMatcher;
use Treblle\Runtime\Masking\StringMatcher;
use Treblle\Runtime\Runtime;
use Treblle\Runtime\Transport\Treblle;

abstract class PackageTestCase extends TestCase
{
    protected function runtime(): Runtime
    {
        return new Runtime(
            transport: new Treblle(
                apiToken: '1234',
                url: 'https://www.treblle.com/',
            ),
            maskingEngine: new MaskingEngine(
                config: $this->config(),
            ),
            start: microtime(true),
        );
    }

    protected function config(): Config
    {
        return new Config(
            api_key: '1234',
            project_id: '1234',
            ignored_environments: ['local'],
            masking: [
                'dob' => DateMatcher::class,
                'cc' => CreditCardMatcher::class,
                'password' => StringMatcher::class,
                'user.email' => EmailMatcher::class,
                'user.dob' => DateMatcher::class,
                'account.*' => StringMatcher::class,
                'account.*.email' => EmailMatcher::class,
                'ss' => SocialSecurityMatcher::class,
                'user.password' => StringMatcher::class,
                'postal_code' => PostalCodeMatcher::class,
            ],
            headers: [
                'Authorization',
                'X-API-KEY',
            ],
        );
    }
}
