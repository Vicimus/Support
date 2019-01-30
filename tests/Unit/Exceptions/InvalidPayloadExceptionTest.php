<?php declare(strict_types = 1);

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
     * @return void
     */
    public function testMessage(): void
    {
        $banana = [];
        $ex = new InvalidPayloadException($banana, 'Campaign', 'Strawberry', self::class);
        $message = $ex->getMessage();
        $this->assertContains('Campaign', $message);
        $this->assertContains('Strawberry', $message);
        $this->assertContains('InvalidPayloadExceptionTest', $message);
    }
}
