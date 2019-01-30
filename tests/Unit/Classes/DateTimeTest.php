<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Classes;

use DateTime as BaseDateTime;
use Vicimus\Support\Classes\DateTime;
use Vicimus\Support\Testing\TestCase;

/**
 * Class DateTimeTest
 */
class DateTimeTest extends TestCase
{
    /**
     * Test make
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testMake(): void
    {
        $this->assertEquals((new BaseDateTime())->format('U'), (new DateTime())->format('U'));
        $this->assertEquals(
            (new BaseDateTime('June 11, 1984'))->format('U'),
            (new DateTime('June 11, 1984'))->format('U')
        );
    }
}
