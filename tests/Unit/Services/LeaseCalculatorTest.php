<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Services;

use PHPUnit\Framework\MockObject\MockObject;
use Vicimus\Support\Interfaces\Financial\LeaseItem;
use Vicimus\Support\Services\LeaseCalculator;
use Vicimus\Support\Testing\TestCase;

/**
 * Class LeaseCalculatorTest
 */
class LeaseCalculatorTest extends TestCase
{
    public function testPayments(): void
    {
        $calc = new LeaseCalculator();
        $payment = $calc->payment(
            0.004_158_333,
            12,
            40,
            35094.17,
            23532.8
        );

        $this->assertEquals(412.19, $payment);
    }

    public function testEasyMode(): void
    {
        /** @var LeaseItem|MockObject $vehicle */
        $vehicle = $this->getMockBuilder(LeaseItem::class)
            ->getMock();

        $vehicle->expects($this->once())
            ->method('msrp')
            ->willReturn(36770.0);

        $vehicle->expects($this->once())
            ->method('price')
            ->willReturn(38694.0);

        $vehicle->expects($this->once())
            ->method('downpayment')
            ->willReturn(3600.0);

        $vehicle->expects($this->once())
            ->method('residual')
            ->willReturn(0.64);

        $vehicle->expects($this->once())
            ->method('rate')
            ->willReturn(0.049_9);

        $vehicle->expects($this->once())
            ->method('term')
            ->willReturn(40.0);

        $calc = new LeaseCalculator();
        $payment = $calc->payment($vehicle);

        $this->assertEquals(412.19, $payment);
    }

    public function testDivisionByZeroIssues(): void
    {
        $calc = new LeaseCalculator();
        $payment = $calc->payment(
            0.000,
            52,
            169,
            47604.17,
            25107.5,
        );

        $this->assertGreaterThan(0, $payment);
    }
}
