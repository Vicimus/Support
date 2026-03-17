<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Services;

use Illuminate\View\Factory;
use Vicimus\Support\Services\Responses;
use Vicimus\Support\Testing\TestCase;

class ResponsesTest extends TestCase
{
    public function testJson(): void
    {
        $factory = $this->basicMock(Factory::class);
        $responses = new Responses($factory);
        $json = $responses->json('banana', 500);
        $this->assertEquals('"banana"', $json->content());
        $this->assertEquals(500, $json->getStatusCode());
    }

    public function testMake(): void
    {
        $factory = $this->basicMock(Factory::class);
        $responses = new Responses($factory);
        $response = $responses->make('strawberry', 422);
        $this->assertEquals('strawberry', $response->content());
        $this->assertEquals(422, $response->getStatusCode());
    }
}
