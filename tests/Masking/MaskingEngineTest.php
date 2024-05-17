<?php

declare(strict_types=1);

namespace Treblle\Runtime\Tests\Masking;

use PHPUnit\Framework\Attributes\Test;
use Treblle\Runtime\Contracts\MaskingEngineContract;
use Treblle\Runtime\Masking\MaskingEngine;
use Treblle\Runtime\Tests\PackageTestCase;

final class MaskingEngineTest extends PackageTestCase
{
    protected function engine(): MaskingEngineContract
    {
        return new MaskingEngine(
            config: $this->config(),
        );
    }

    #[Test]
    public function it_can_mask_a_string(): void
    {
        $engine = $this->engine();

        $this->assertEquals(
            expected: [
                'password' => '********'
            ],
            actual: $engine->mask(
                payload: [
                    'password' => '12345678'
                ],
            ),
        );
    }

    #[Test]
    public function it_can_mask_a_nested_value(): void
    {
        $engine = $this->engine();

        $this->assertEquals(
            expected: [
                'user' => [
                    'password' => '********'
                ]
            ],
            actual: $engine->mask(
                payload: [
                    'user' => [
                        'password' => '12345678'
                    ]
                ],
            ),
        );
    }

    #[Test]
    public function it_can_mask_a_date_correctly(): void
    {
        $engine = $this->engine();

        $this->assertEquals(
            expected: [
                'dob' => '09/09/****',
            ],
            actual: $engine->mask(
                payload: [
                    'dob' => '09/09/1988',
                ],
            )
        );
    }

    #[Test]
    public function it_can_mask_a_credit_card_number(): void
    {
        $engine = $this->engine();

        $this->assertEquals(
            expected: [
                'cc' => '****-****-****-1234',
            ],
            actual: $engine->mask(
                payload: [
                    'cc' => '1234-1234-1234-1234',
                ],
            )
        );
    }

    #[Test]
    public function it_can_mask_an_email_address(): void
    {
        $engine = $this->engine();

        $this->assertEquals(
            expected: [
                'user' => [
                    'email' => '****@domain.com',
                ],
            ],
            actual: $engine->mask(
                payload: [
                    'user' => [
                        'email' => 'user@domain.com',
                    ],
                ],
            )
        );
    }

    #[Test]
    public function it_can_mask_a_postal_code(): void
    {
        $engine = $this->engine();

        $this->assertEquals(
            expected: [
                'postal_code' => 'B33 ***',
            ],
            actual: $engine->mask(
                payload: [
                    'postal_code' => 'B33 8TH',
                ],
            ),
        );
    }

    #[Test]
    public function it_can_mask_a_social_security_number(): void
    {
        $engine = $this->engine();

        $this->assertEquals(
            expected: [
                'ss' => '***-**-6789',
            ],
            actual: $engine->mask(
                payload: [
                    'ss' => '123-45-6789',
                ],
            ),
        );
    }
}
