<?php

declare(strict_types=1);

namespace Treblle\Runtime\Tests;

use Exception;
use PHPUnit\Framework\Attributes\Test;
use Treblle\Runtime\Contracts\MaskingEngineContract;
use Treblle\Runtime\Runtime;
use Treblle\Runtime\Transport\Treblle;

final class RuntimeTest extends PackageTestCase
{
    #[Test]
    public function it_can_create_a_new_runtime(): void
    {
        $this->assertInstanceOf(
            expected: Runtime::class,
            actual: $this->runtime(),
        );
    }

    #[Test]
    public function it_can_add_a_request(): void
    {
        $runtime = $this->runtime()->request(
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
                        'payments' => [
                            'cc' => '1234-1234-1234-1234',
                        ],
                    ],
                    'ss' => '123-23-2345',
                ],
            ],
        );

        $this->assertArrayHasKey(
            key: 'request',
            array: $runtime->data,
        );

        $this->assertEquals(
            expected: [
                'request' => [
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
                            'email' => '*****@example.com',
                            'dob' => '09/09/****',
                            'password' => '********',
                            'payments' => [
                                'cc' => '1234-1234-1234-1234',
                            ],
                        ],
                        'ss' => '***-**-2345',
                    ],
                ],
            ],
            actual: $runtime->data,
        );
    }

    #[Test]
    public function it_can_add_a_response(): void
    {
        $runtime = $this->runtime()->response(
            data: [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'code' => 200,
                'size' => 123,
                'load_time' => 1234,
                'memory_usage' => 1234,
                'body' => [
                    'password' => 'password',
                ],
            ],
        );

        $this->assertArrayHasKey(
            key: 'response',
            array: $runtime->data,
        );

        $this->assertEquals(
            expected: [
                'response' => [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'code' => 200,
                    'size' => 123,
                    'load_time' => 1234,
                    'memory_usage' => 1234,
                    'body' => [
                        'password' => '********',
                    ],
                ],
            ],
            actual: $runtime->data,
        );
    }

    #[Test]
    public function it_can_mask_request_headers(): void
    {
        $runtime = $this->runtime()->request(
            data: [
                'timestamp' => '2024-05-16:12:12:12',
                'ip' => '127.0.0.1',
                'url' => 'https://api.something.com',
                'user_agent' => 'Some Agent',
                'method' => 'GET',
                'headers' => [
                    'Authorization' => 'Bearer 12345',
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
                        'payments' => [
                            'cc' => '1234-1234-1234-1234',
                        ],
                    ],
                    'ss' => '123-23-2345',
                ],
            ],
        );

        $this->assertArrayHasKey(
            key: 'request',
            array: $runtime->data,
        );

        $this->assertEquals(
            expected: [
                'request' => [
                    'timestamp' => '2024-05-16:12:12:12',
                    'ip' => '127.0.0.1',
                    'url' => 'https://api.something.com',
                    'user_agent' => 'Some Agent',
                    'method' => 'GET',
                    'headers' => [
                        'Authorization' => '************',
                        'content_type' => 'application/json',
                        'content_length' => 123,
                        'host' => 'https://api.something.com',
                        'user_agent' => 'Some Agent',
                    ],
                    'body' => [
                        'user' => [
                            'name' => 'Steve',
                            'email' => '*****@example.com',
                            'dob' => '09/09/****',
                            'password' => '********',
                            'payments' => [
                                'cc' => '1234-1234-1234-1234',
                            ],
                        ],
                        'ss' => '***-**-2345',
                    ],
                ],
            ],
            actual: $runtime->data,
        );
    }

    #[Test]
    public function it_can_mask_response_headers(): void
    {
        $runtime = $this->runtime()->response(
            data: [
                'headers' => [
                    'Authorization' => 'Basic 12345',
                    'X-API-KEY' => '12345',
                    'Accept' => 'application/json',
                ],
                'code' => 200,
                'size' => 123,
                'load_time' => 1234,
                'memory_usage' => 1234,
                'body' => [
                    'password' => 'password',
                ],
            ],
        );

        $this->assertArrayHasKey(
            key: 'response',
            array: $runtime->data,
        );

        $this->assertEquals(
            expected: [
                'response' => [
                    'headers' => [
                        'Authorization' => '***********',
                        'X-API-KEY' => '*****',
                        'Accept' => 'application/json',
                    ],
                    'code' => 200,
                    'size' => 123,
                    'load_time' => 1234,
                    'memory_usage' => 1234,
                    'body' => [
                        'password' => '********',
                    ],
                ],
            ],
            actual: $runtime->data,
        );
    }

    #[Test]
    public function process_will_trigger_the_send_method(): void
    {
        $transport = $this->createMock(Treblle::class);
        $maskingEngine = $this->createMock(MaskingEngineContract::class);

        $runtime = $this->getMockBuilder(Runtime::class)
            ->setConstructorArgs([$transport, $maskingEngine])
            ->onlyMethods(['send'])
            ->getMock();

        $runtime->expects($this->once())->method('send');

        $runtime->process();
    }

    #[Test]
    public function no_exceptions_are_thrown_on_the_process_method(): void
    {
        $transport = $this->createMock(Treblle::class);
        $maskingEngine = $this->createMock(MaskingEngineContract::class);

        $runtime = $this->getMockBuilder(Runtime::class)
            ->setConstructorArgs([$transport, $maskingEngine])
            ->onlyMethods(['send'])
            ->getMock();

        $runtime->method('send')->will($this->throwException(new Exception('Test exception')));

        $runtime->process();

        $this->assertTrue(true);
    }

    #[Test]
    public function it_can_send_the_request(): void
    {
        $transport = $this->createMock(Treblle::class);
        $maskingEngine = $this->createMock(MaskingEngineContract::class);

        $transport->expects($this->once())
            ->method('ingress')
            ->with($this->arrayHasKey('load_time'));

        $runtime = new Runtime($transport, $maskingEngine, microtime(true));

        $runtime->send();
    }
}
