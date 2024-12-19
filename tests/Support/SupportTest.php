<?php

declare(strict_types=1);

namespace Treblle\Runtime\Tests\Support;

use PHPUnit\Framework\Attributes\Test;
use Treblle\Runtime\Support\PHP;
use Treblle\Runtime\Tests\PackageTestCase;

final class SupportTest extends PackageTestCase
{
    #[Test]
    public function it_can_get_the_version(): void
    {
        $this->assertEquals(
            expected: PHP_VERSION,
            actual: PHP::version(),
        );
    }

    #[Test]
    public function it_can_get_the_name_of_the_language(): void
    {
        $this->assertEquals(
            expected: 'php',
            actual: PHP::name(),
        );
    }

    #[Test]
    public function it_can_get_the_expose_php_ini_value(): void
    {
        $this->assertEquals(
            expected: 'On',
            actual: PHP::exposePHP(),
        );
    }

    #[Test]
    public function it_can_get_the_display_errors_ini_value(): void
    {
        $this->assertEquals(
            expected: 'On',
            actual: PHP::displayErrors(),
        );
    }
}
