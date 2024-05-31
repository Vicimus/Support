<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\BasicVideo;

/**
 * Class VideoTypeTest
 */
class BasicVideoTest extends TestCase
{
    /**
     * Test a basic video
     */
    public function testBasicVideo(): void
    {
        $type = new BasicVideo('mp4', 'www.myvideo.com/video.mp4');

        $this->assertSame('mp4', $type->videoType());
        $this->assertSame('www.myvideo.com/video.mp4', $type->videoValue());
    }
}
