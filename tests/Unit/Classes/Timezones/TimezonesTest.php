<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Classes\Timezones;

use Vicimus\Support\Classes\Timezones\Timezone;
use Vicimus\Support\Classes\Timezones\Timezones;
use Vicimus\Support\Testing\BasicCache;
use Vicimus\Support\Testing\TestCase;

/**
 * Class TimezonesTest
 */
class TimezonesTest extends TestCase
{
    /**
     * Test getting all time zones
     *
     * @return void
     */
    public function testAll(): void
    {
        $service = new Timezones(new BasicCache());

        $timezones = $service->all();
        $this->assertGreaterThan(0, $timezones->count());
        $this->assertInstanceOf(Timezone::class, $timezones->first());
    }
}
