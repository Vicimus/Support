<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests;

use Vicimus\Support\Exceptions\InvalidPayloadException;
use Vicimus\Support\Testing\TestCase;

/**
 * Class InvalidPayloadExceptionTest
 */
class InvalidPayloadExceptionTest extends TestCase
{
    /**
     * Test message
     *
     */
    public function testMessage(): void
    {
        $banana = [];
        $ex = new InvalidPayloadException($banana, 'Campaign', 'Strawberry', self::class);
        $message = $ex->getMessage();
        $this->assertStringContainsString('Campaign', $message);
        $this->assertStringContainsString('Strawberry', $message);
        $this->assertStringContainsString('InvalidPayloadExceptionTest', $message);
    }
}
