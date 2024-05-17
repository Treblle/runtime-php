<?php

declare(strict_types=1);

use Treblle\Runtime\DataObjects\Config;
use Treblle\Runtime\Masking;
use Treblle\Runtime\Runtime;
use Treblle\Runtime\Transport\Treblle;

require __DIR__ . '/vendor/autoload.php';

$runtime = new Runtime(
    transport: new Treblle(
        apiToken: '1234',
        url: 'https://httpdump.app',
    ),
    maskingEngine: new Masking\MaskingEngine(
        config: new Config(
            api_key: '1234',
            project_id: '1234',
            ignored_environments: ['local'],
            masking: [
                'password' => Masking\StringMatcher::class,
                'dob' => Masking\DateMatcher::class,
            ],
        ),
    ),
);

$runtime->process(
    data: [

    ],
);


