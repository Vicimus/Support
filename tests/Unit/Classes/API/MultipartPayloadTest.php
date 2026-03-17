<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\API;

use Illuminate\Http\File;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\API\MultipartPayload;

/**
 * Class MultipartPayloadTest
 */
class MultipartPayloadTest extends TestCase
{
    /**
     * Format the payload
     *
     */
    public function testFormat(): void
    {
        $payload = new MultipartPayload(
            'my_image',
            'aStringValue'
        );

        $format = $payload->format();
        $this->assertEquals('application/json', $format['Content-Type']);
        $this->assertEquals('my_image', $format['name']);
        $this->assertEquals('aStringValue', $format['contents']);

        $array = ['id' => 5];
        $payload = new MultipartPayload(
            'my_image',
            $array
        );

        $format = $payload->format();
        $this->assertEquals(json_encode($array), $format['contents']);
    }

    /**
     * Format the payload
     *
     */
    public function testFormatWithFile(): void
    {
        $file = $this->getMockBuilder(File::class)
            ->disableOriginalConstructor()
            ->getMock();

        $file->method('getFilename')
            ->willReturn(__FILE__);

        $file->method('getPathname')
            ->willReturn(__DIR__);

        $file->method('getMimeType')
            ->willReturn('image/jpg');

        $payload = new MultipartPayload(
            'my_image',
            $file
        );

        $format = $payload->format();
        $this->assertEquals('multipart/form-data', $format['Content-Type']);
        $this->assertEquals('my_image', $format['name']);
        $this->assertIsResource($format['contents']);
        $this->assertEquals('image/jpg', $format['mime']);

        $array = ['id' => 5];
        $payload = new MultipartPayload(
            'my_image',
            $array
        );

        $format = $payload->format();
        $this->assertEquals(json_encode($array), $format['contents']);

        $payload = new MultipartPayload(
            'myImage',
            $file,
            null,
            'banana'
        );

        $format = $payload->format();
        $this->assertEquals('banana', $format['mime']);
    }
}
