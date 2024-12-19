<?php

declare(strict_types=1);

namespace Treblle\Runtime\Tests\Transport;

use JustSteveKing\Sdk\Client;
use JustSteveKing\Sdk\Contracts\ClientContract;
use PHPUnit\Framework\Attributes\Test;
use Treblle\Runtime\Tests\PackageTestCase;

final class TreblleTest extends PackageTestCase
{
    #[Test]
    public function it_can_create_a_treblle_instance(): void
    {
        $this->assertInstanceOf(
            expected: Client::class,
            actual: $this->runtime()->transport,
        );
    }

    #[Test]
    public function it_will_create_an_interoperable_http_client(): void
    {
        $this->assertInstanceOf(
            expected: ClientContract::class,
            actual: $this->runtime()->transport->setup(),
        );
    }
}
