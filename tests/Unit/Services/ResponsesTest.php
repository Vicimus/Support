<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Services;

use Vicimus\Support\Services\Responses;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ResponsesTest
 */
class ResponsesTest extends TestCase
{
    /**
     * Test json
     *
     * @return void
     */
    public function testJson(): void
    {
        $responses = new Responses();
        $json = $responses->json('banana', 500);
        $this->assertEquals('"banana"', $json->content());
        $this->assertEquals(500, $json->getStatusCode());
    }

    /**
     * Test make
     *
     * @return void
     */
    public function testMake(): void
    {
        $responses = new Responses();
        $response = $responses->make('strawberry', 422);
        $this->assertEquals('strawberry', $response->content());
        $this->assertEquals(422, $response->getStatusCode());
    }
}
