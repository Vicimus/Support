<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Traits;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Traits\Processing;

/**
 * Class ProcessorTest
 */
class ProcessorTest extends TestCase
{
    /**
     * Options
     *
     * @return void
     */
    public function testOptions(): void
    {
        /** @var Processing|MockObject $processor */
        $processor = $this->getMockForTrait(Processing::class);
        $this->assertTrue(is_numeric($processor->priority()));

        $processor->options([
            'banana' => 'strawberry',
        ]);

        $this->assertNull($processor->option('apple'));
        $this->assertEquals('strawberry', $processor->option('banana'));
    }
}
