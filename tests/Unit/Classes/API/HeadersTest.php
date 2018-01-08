<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\API\Headers;

/**
 * Class ImmutableObjectTest
 */
class HeadersTest extends TestCase
{
    /**
     * Get a header
     *
     * @return void
     */
    public function testHeadersGet(): void
    {
        /* @var Response|\PHPUnit\Framework\MockObject\MockObject $response */
        $response = $this->getMockBuilder(Response::class)
            ->getMock();

        $response->expects($this->once())
            ->method('getHeaders')
            ->willReturn([
                'banana' => 'strawberry',
                'oranges' => [
                    'are',
                    'great',
                ],
            ]);

        $headers = new Headers($response);
        $this->assertEquals('strawberry', $headers->get('banana'));
        $this->assertNull($headers->get('apples'));
        $this->assertEquals("are\ngreat", $headers->get('oranges'));
    }
}
