<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Vicimus\Support\Classes\Benchmark;
use Vicimus\Support\Testing\TestCase;

/**
 * Class BenchmarkTest
 */
class BenchmarkTest extends TestCase
{
    /**
     * Custom set
     *
     * @return void
     */
    public function testCustomSetting(): void
    {
        $bench = new Benchmark();
        $bench->custom(function ($bench): void {
            //
        }, function (): string {
            return 'banana';
        });

        $bench->init()->stop();
        $results = $bench->get();
        $this->assertEquals('banana', $results['customs'][0]);
        $bench->output();
    }
}
