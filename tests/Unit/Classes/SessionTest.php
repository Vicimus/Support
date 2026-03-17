<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Session;

/**
 * Class SessionTest
 */
class SessionTest extends TestCase
{
    /**
     * Set up the test
     *
     */
    public function setup(): void
    {
        $GLOBALS['_SESSION'] = [];
    }

    /**
     * Test put
     *
     */
    public function testPutAndForgetAndGet(): void
    {
        $session = new Session();

        $this->assertArrayNotHasKey('banana', $_SESSION);

        $session->put('banana', 'strawberry');
        $this->assertEquals('strawberry', $_SESSION['banana']);

        $value = $session->get('banana');
        $this->assertEquals('strawberry', $value);
        $this->assertNull($session->get('apples'));

        $session->forget('banana');
        $this->assertArrayNotHasKey('banana', $_SESSION);

        $session->put('banana', 'apples');
        $value = $session->pull('banana');
        $this->assertEquals('apples', $value);

        $this->assertArrayNotHasKey('banana', $_SESSION);

        $this->assertNull($session->pull('strawberry'));
    }
}
