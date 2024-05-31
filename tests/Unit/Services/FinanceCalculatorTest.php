<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Services;

use Vicimus\Support\Services\FinanceCalculator;
use Vicimus\Support\Testing\TestCase;

/**
 * Class FinanceCalculatorTest
 */
class FinanceCalculatorTest extends TestCase
{
    private FinanceCalculator $calculator;

    /**
     */
    public function setup(): void
    {
        parent::setup();

        $this->calculator = new FinanceCalculator();
    }

    /**
     */
    public function testPayment(): void
    {
        $this->assertEquals(488.31, $this->calculator->payment(
            4.5,
            26,
            35600,
            36,
        ));

        $this->assertEquals(456.41, $this->calculator->payment(
            0,
            26,
            35600,
            36,
        ));

        $this->assertEquals(988.89, $this->calculator->payment(
            0,
            12,
            35600,
            36,
        ));
    }
}
