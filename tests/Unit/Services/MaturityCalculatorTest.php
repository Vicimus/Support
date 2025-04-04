<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Services;

use Carbon\Carbon;
use Vicimus\Support\Services\MaturityCalculator;
use Vicimus\Support\Testing\TestCase;

/**
 *
 */
class MaturityCalculatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testCalculate(): void
    {
        $calculator = new MaturityCalculator();

        $purchaseDate = new Carbon('2025-04-03 12:00:00');

        // Term of 1 is always a cash deal and not a valid finance or lease deal
        $this->assertEquals(null, $calculator->calculate($purchaseDate, 0));
        $this->assertEquals(null, $calculator->calculate($purchaseDate, 1));

        // Between 2 and 12 are always monthly
        $this->assertEquals('2025-06-03', $calculator->calculate($purchaseDate, 2)->format('Y-m-d'));
        $this->assertEquals('2025-07-03', $calculator->calculate($purchaseDate, 3)->format('Y-m-d'));
        $this->assertEquals('2025-08-03', $calculator->calculate($purchaseDate, 4)->format('Y-m-d'));
        $this->assertEquals('2025-09-03', $calculator->calculate($purchaseDate, 5)->format('Y-m-d'));
        $this->assertEquals('2025-10-03', $calculator->calculate($purchaseDate, 6)->format('Y-m-d'));
        $this->assertEquals('2025-11-03', $calculator->calculate($purchaseDate, 7)->format('Y-m-d'));
        $this->assertEquals('2025-12-03', $calculator->calculate($purchaseDate, 8)->format('Y-m-d'));
        $this->assertEquals('2026-01-03', $calculator->calculate($purchaseDate, 9)->format('Y-m-d'));
        $this->assertEquals('2026-02-03', $calculator->calculate($purchaseDate, 10)->format('Y-m-d'));
        $this->assertEquals('2026-03-03', $calculator->calculate($purchaseDate, 11)->format('Y-m-d'));
        $this->assertEquals('2026-04-03', $calculator->calculate($purchaseDate, 12)->format('Y-m-d'));

        // Obviously monthly
        $this->assertEquals('2027-04-03', $calculator->calculate($purchaseDate, 24)->format('Y-m-d'));
        $this->assertEquals('2028-04-03', $calculator->calculate($purchaseDate, 36)->format('Y-m-d'));
        $this->assertEquals('2029-04-03', $calculator->calculate($purchaseDate, 48)->format('Y-m-d'));
        $this->assertEquals('2030-04-03', $calculator->calculate($purchaseDate, 60)->format('Y-m-d'));
        $this->assertEquals('2031-04-03', $calculator->calculate($purchaseDate, 72)->format('Y-m-d'));
        $this->assertEquals('2032-04-03', $calculator->calculate($purchaseDate, 84)->format('Y-m-d'));
        $this->assertEquals('2033-04-03', $calculator->calculate($purchaseDate, 96)->format('Y-m-d'));

        // Obviously bi-weekly
        $this->assertEquals('2026-04-03', $calculator->calculate($purchaseDate, 26)->format('Y-m-d'));
        $this->assertEquals('2027-04-03', $calculator->calculate($purchaseDate, 52)->format('Y-m-d'));
        $this->assertEquals('2028-04-03', $calculator->calculate($purchaseDate, 78)->format('Y-m-d'));
        $this->assertEquals('2029-04-03', $calculator->calculate($purchaseDate, 104)->format('Y-m-d'));
        $this->assertEquals('2030-04-03', $calculator->calculate($purchaseDate, 130)->format('Y-m-d'));
        $this->assertEquals('2031-04-03', $calculator->calculate($purchaseDate, 156)->format('Y-m-d'));
        $this->assertEquals('2032-04-03', $calculator->calculate($purchaseDate, 182)->format('Y-m-d'));
        $this->assertEquals('2033-04-03', $calculator->calculate($purchaseDate, 208)->format('Y-m-d'));

        // Probably monthly
        $this->assertEquals('2031-07-03', $calculator->calculate($purchaseDate, 75)->format('Y-m-d'));
        $this->assertEquals('2033-03-03', $calculator->calculate($purchaseDate, 95)->format('Y-m-d'));

        // Probably bi-weekly
        $this->assertEquals('2029-01-22', $calculator->calculate($purchaseDate, 99)->format('Y-m-d'));
        $this->assertEquals('2031-03-19', $calculator->calculate($purchaseDate, 155)->format('Y-m-d'));
        $this->assertEquals('2033-03-18', $calculator->calculate($purchaseDate, 207)->format('Y-m-d'));

        // Probably an error or lazy dealership employee
        $this->assertEquals(null, $calculator->calculate($purchaseDate, 209));
    }
}
