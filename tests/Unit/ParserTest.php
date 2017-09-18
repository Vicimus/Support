<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Parser;

/**
 * Class ParserTest
 *
 * @package Vicimus\Support\Tests\Unit
 */
class ParserTest extends TestCase
{
    /**
     * Test parse sale classes function.
     *
     * @return void
     */
    public function testParseVehicleSaleClass(): void
    {
        $result = Parser::parseVehicleSaleClass('used');
        $this->assertEquals('used', $result);

        $result = Parser::parseVehicleSaleClass('new');
        $this->assertEquals('new', $result);

        $result = Parser::parseVehicleSaleClass('usagee');
        $this->assertEquals('used', $result);

        $result = Parser::parseVehicleSaleClass('usagé');
        $this->assertEquals('used', $result);

        $result = Parser::parseVehicleSaleClass('usageefpowiej');
        $this->assertNull($result);

        $result = Parser::parseVehicleSaleClass('neuf');
        $this->assertEquals('new', $result);
    }

    /**
     * Test parse makes function.
     *
     * @return void
     */
    public function testParseVehicleMake(): void
    {
        $result = Parser::parseVehicleMake('acura');
        $this->assertEquals('Acura', $result);

        $result = Parser::parseVehicleMake('bmw');
        $this->assertEquals('BMW', $result);

        $result = Parser::parseVehicleMake('Rolls Royce');
        $this->assertEquals('Rolls-Royce', $result);

        $result = Parser::parseVehicleMake('Land Rover');
        $this->assertEquals('Land Rover', $result);

        $result = Parser::parseVehicleMake('Alfaromeo');
        $this->assertEquals('Alfa Romeo', $result);

        $result = Parser::parseVehicleMake('lambo');
        $this->assertEquals('Lamborghini', $result);

        $result = Parser::parseVehicleMake('RAM Truck');
        $this->assertEquals('RAM', $result);

        $result = Parser::parseVehicleMake('Honda Accord');
        $this->assertEquals('Honda', $result);

    }

    /**
     * Test parse country function.
     *
     * @return void
     */
    public function testParseCountry(): void
    {
        $result = Parser::parseCountry('ca');
        $this->assertEquals('CA', $result);

        $result = Parser::parseCountry('Canada');
        $this->assertEquals('CA', $result);

        $result = Parser::parseCountry('USA');
        $this->assertEquals('US', $result);

        $result = Parser::parseCountry('US');
        $this->assertEquals('US', $result);

        $result = Parser::parseCountry('United-States');
        $this->assertEquals('US', $result);

        $result = Parser::parseCountry('United-States of America');
        $this->assertEquals('US', $result);
    }

    /**
     * Test parse language function.
     *
     * @return void
     */
    public function testParseLanguage(): void
    {
        $result = Parser::parseLanguage('en');
        $this->assertEquals('en', $result);

        $result = Parser::parseLanguage('fr');
        $this->assertEquals('fr', $result);

        $result = Parser::parseLanguage('english');
        $this->assertEquals('en', $result);

        $result = Parser::parseLanguage('français');
        $this->assertEquals('fr', $result);

        $result = Parser::parseLanguage('eng');
        $this->assertEquals('en', $result);

        $result = Parser::parseLanguage('fra');
        $this->assertEquals('fr', $result);
    }

    /**
     * Test parse mileage unit function.
     *
     * @return void
     */
    public function testParseMileageUnit(): void
    {
        $result = Parser::parseMileageUnit('km');
        $this->assertEquals('km', $result);

        $result = Parser::parseMileageUnit('mi');
        $this->assertEquals('mi', $result);

        $result = Parser::parseMileageUnit('miles');
        $this->assertEquals('mi', $result);

        $result = Parser::parseMileageUnit('kilometers');
        $this->assertEquals('km', $result);

        $result = Parser::parseMileageUnit('kilomètres');
        $this->assertEquals('km', $result);
    }

    /**
     * Test parse payment type function.
     *
     * @return void
     */
    public function testParsePaymentType(): void
    {
        $result = Parser::parsePaymentType('Cash');
        $this->assertEquals('cash', $result);

        $result = Parser::parsePaymentType('Lease');
        $this->assertEquals('lease', $result);

        $result = Parser::parsePaymentType('Financing');
        $this->assertEquals('finance', $result);

        $result = Parser::parsePaymentType('Comptant');
        $this->assertEquals('cash', $result);

        $result = Parser::parsePaymentType('location');
        $this->assertEquals('lease', $result);

        $result = Parser::parsePaymentType('Financement');
        $this->assertEquals('finance', $result);
    }

    /**
     * Test parse timezone function.
     *
     * @return void
     */
    public function testParseTimezone(): void
    {
        $result = Parser::parseTimezone('PST');
        $this->assertEquals('PST', $result);

        $result = Parser::parseTimezone('eastern');
        $this->assertEquals('EST', $result);

        $result = Parser::parseTimezone('Heure de l\'Atlantique');
        $this->assertEquals('ADT', $result);

        $result = Parser::parseTimezone('Mountain timezone');
        $this->assertEquals('MST', $result);
    }

    /**
     * Test parse state function.
     *
     * @return void
     */
    public function testParseState(): void
    {
        $result = Parser::parseState('Québec', 'CA');
        $this->assertEquals('QC', $result);

        $result = Parser::parseState('Ontario', 'CA');
        $this->assertEquals('ON', $result);

        $result = Parser::parseState('Alabama', 'US');
        $this->assertEquals('AL', $result);
    }
}
