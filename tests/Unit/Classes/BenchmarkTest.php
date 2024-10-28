<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Vicimus\Support\Classes\Benchmark;
use Vicimus\Support\Testing\TestCase;

class BenchmarkTest extends TestCase
{
    public function testCustomSetting(): void
    {
        $bench = new Benchmark();
        $bench->custom(static function ($bench): void {
            //
        }, static fn (): string => 'banana');

        $bench->init()->stop();
        $results = $bench->get();
        $this->assertEquals('banana', $results['customs'][0]);
        $bench->output();
    }
}
