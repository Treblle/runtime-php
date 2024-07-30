<?php

declare(strict_types=1);

use Treblle\Runtime\DataObjects\Config;
use Treblle\Runtime\Masking;
use Treblle\Runtime\Runtime;
use Treblle\Runtime\Transport\Treblle;

require __DIR__ . '/vendor/autoload.php';

// will be built by the implementation.
// $config = Config::make(config('treblle'));
$config = new Config(
    api_key: '1234',
    project_id: '1234',
    ignored_environments: ['local'],
    masking: [
        'email' => Masking\EmailMatcher::class,
        'password' => Masking\StringMatcher::class,
        'account.*' => Masking\StringMatcher::class,
        'user.email' => Masking\EmailMatcher::class,
        'user.dob' => Masking\DateMatcher::class,
        'user.password' => Masking\StringMatcher::class,
        'user.ss' => Masking\SocialSecurityMatcher::class,
        'user.payments.cc' => Masking\CreditCardMatcher::class,
        'cc' => Masking\CreditCardMatcher::class,
    ],
    headers: [
        'Authorization',
        'X-API-KEY',
    ],
);

$runtime = new Runtime(
    transport: new Treblle(
        apiToken: '1234',
        url: 'https://httpdump.app',
    ),
    maskingEngine: new Masking\MaskingEngine(
        config: $config,
    ),
    start: microtime(true),
);

// this happens in the middleware
$runtime->request(
    data: [
        'timestamp' => '2024-05-16:12:12:12',
        'ip' => '127.0.0.1',
        'url' => 'https://api.something.com',
        'user_agent' => 'Some Agent',
        'method' => 'GET',
        'headers' => [
            'content_type' => 'application/json',
            'content_length' => 123,
            'host' => 'https://api.something.com',
            'user_agent' => 'Some Agent',
        ],
        'body' => [
            'user' => [
                'name' => 'Steve',
                'email' => 'steve@example.com',
                'dob' => '09/09/1988',
                'password' => 'password',
                'ss' => '123-23-2345',
                'payments' => [
                    'cc' => '1234-1234-1234-1234',
                ],
            ],
        ],
    ],
);


// this happens in the middleware
$runtime->response(
    data: [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'code' => 200,
        'size' => 123,
        'load_time' => 1234,
        'memory_usage' => memory_get_peak_usage(),
        'body' => [
            'password' => 'password',
        ],
    ],
);

//$runtime->start = microtime(true);

$runtime->process();
