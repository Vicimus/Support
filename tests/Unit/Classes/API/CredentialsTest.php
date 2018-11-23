<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Classes\API;

use Vicimus\Support\Classes\API\Credentials;
use Vicimus\Support\Testing\TestCase;

/**
 * Class CredentialsTest
 */
class CredentialsTest extends TestCase
{
    /**
     * Test the constructor
     *
     * @return void
     */
    public function testMake(): void
    {
        $credentials = new Credentials('banana', 'strawberry', 'apple');
        $this->assertSame('banana', $credentials->url);
        $this->assertSame('strawberry', $credentials->id);
        $this->assertSame('apple', $credentials->secret);
    }
}
