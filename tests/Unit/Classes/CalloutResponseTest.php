<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Illuminate\Support\Collection;
use Vicimus\Support\Classes\CalloutResponse;
use Vicimus\Support\Testing\TestCase;

/**
 * Class CalloutResponseTest
 */
class CalloutResponseTest extends TestCase
{
    /**
     * Custom set
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $conquest = new Collection();
        $retention = new Collection();

        $response = new CalloutResponse($conquest, $retention);
        $this->assertCount(0, $response->conquest);
        $this->assertCount(0, $response->retention);
    }
}
