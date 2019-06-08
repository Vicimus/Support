<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Locale;

use Vicimus\Support\Locale\States;
use Vicimus\Support\Testing\TestCase;

/**
 * Class StatesTest
 */
class StatesTest extends TestCase
{
    /**
     * Test states
     *
     * @return void
     */
    public function testStates(): void
    {
        $this->assertGreaterThan(0, States::STATES['CA']);
    }
}
