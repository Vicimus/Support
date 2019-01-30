<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;
use Vicimus\Support\Classes\Timer;

/**
 * Class TimerTest
 */
class TimerTest extends TestCase
{
    /**
     * Assert invoke
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $caught = false;
        $timer = new Timer('status', static function (): void {
            throw new Exception('Fail the timer');
        }, 0.001);

        for ($index = 0; $index < 1000000; ++$index) {
            try {
                $timer->invoke();
            } catch (Throwable $ex) {
                $caught = true;
                break;
            }
        }

        $this->assertTrue($caught);
    }
}
