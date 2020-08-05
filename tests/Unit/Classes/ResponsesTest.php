<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Vicimus\Support\Classes\Responses;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ResponsesTest
 */
class ResponsesTest extends TestCase
{
    /**
     * Test Json
     * @return void
     */
    public function testJson(): void
    {
        $responses = new Responses();
        $json = $responses->json('banana');
        $this->assertStringContainsString('banana', $json->getContent());
    }


    /**
     * Test Make
     * @return void
     */
    public function testMake(): void
    {
        $responses = new Responses();
        $generic = $responses->make('banana');
        $this->assertStringContainsString('banana', $generic->getContent());
    }
}
