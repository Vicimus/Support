<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Services;

use PHPUnit\Framework\MockObject\MockObject;
use Vicimus\Support\Interfaces\Financial\HasDownpayment;
use Vicimus\Support\Interfaces\Financial\HasPrice;
use Vicimus\Support\Interfaces\Financial\HasRate;
use Vicimus\Support\Interfaces\Financial\HasTerm;
use Vicimus\Support\Interfaces\Financial\LeaseItem;
use Vicimus\Support\Interfaces\Financial\HasLeaseRate;
use Vicimus\Support\Services\Calculator;
use Vicimus\Support\Testing\TestCase;

/**
 * Class LeaseCalculatorTest
 */
class LeaseCalculatorTest extends TestCase
{
    /**
     * Test payments
     *
     * @return void
     */
    public function testPayments(): void
    {
        $calc = new Calculator();
        $payment = $calc->payment(
            0.004158333,
            12,
            40,
            35094.17,
            23532.8
        );

        $this->assertEquals(412.19, $payment);
    }

    /**
     * Test rate calculation
     *
     * @return void
     */
    public function testRate(): void
    {
        /** @var HasRate|MockObject $mock */
        $mock = $this->getMockBuilder(HasRate::class)
            ->getMock();
        $mock->expects($this->once())
            ->method('rate')
            ->willReturn(0.0499);

        $calc = new Calculator();
        $rate = $calc->rate($mock);
        $this->assertEquals(0.004158333, $rate);
    }

    /**
     * Calculates Nper
     *
     * @return void
     */
    public function testNper(): void
    {
        /** @var HasTerm|MockObject $mock */
        $mock = $this->getMockBuilder(HasTerm::class)
            ->getMock();
        $mock->expects($this->once())
            ->method('term')
            ->willReturn(40);

        $calc = new Calculator();
        $nper = $calc->nper($mock, 12);
        $this->assertEquals(40, $nper);
    }

    /**
     * Calculate present value
     *
     * @return void
     */
    public function testPresentValue(): void
    {
        $calc = new Calculator();

        /** @var HasPrice|MockObject $mock */
        $mock = $this->getMockBuilder(HasPrice::class)
            ->getMock();

        $mock->expects($this->once())
            ->method('price')
            ->willReturn(36000);

        /** @var HasDownpayment|MockObject $down */
        $down = $this->getMockBuilder(HasDownpayment::class)
            ->getMock();

        $down->expects($this->once())
            ->method('downpayment')
            ->willReturn(2000);

        $price = $calc->presentValue($mock, $down);
        $this->assertEquals(34000, $price);
    }

    /**
     * Future value
     *
     * @return void
     */
    public function testFutureValue(): void
    {
        $calc = new Calculator();

        /** @var HasPrice|MockObject $mock */
        $mock = $this->getMockBuilder(HasPrice::class)
            ->getMock();

        $mock->expects($this->once())
            ->method('msrp')
            ->willReturn(36000);

        $residual = $this->getMockBuilder(HasLeaseRate::class)
            ->getMock();

        $residual->expects($this->once())
            ->method('residual')
            ->willReturn(0.64);

        $future = $calc->futureValue($mock, $residual);
        $this->assertEquals(23040, $future);
    }

    /**
     * Easy mode
     *
     * @return void
     */
    public function testEasyMode(): void
    {
        /** @var LeaseItem|MockObject $vehicle */
        $vehicle = $this->getMockBuilder(LeaseItem::class)
            ->getMock();

        $vehicle->expects($this->once())
            ->method('msrp')
            ->willReturn(36770);

        $vehicle->expects($this->once())
            ->method('price')
            ->willReturn(38694);

        $vehicle->expects($this->once())
            ->method('downpayment')
            ->willReturn(3600);

        $vehicle->expects($this->once())
            ->method('residual')
            ->willReturn(0.64);

        $vehicle->expects($this->once())
            ->method('rate')
            ->willReturn(0.0499);

        $vehicle->expects($this->once())
            ->method('term')
            ->willReturn(40);

        $calc = new Calculator();
        $payment = $calc->payment($vehicle);

        $this->assertEquals(412.19, $payment);
    }
}
