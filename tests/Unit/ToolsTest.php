<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Tools;
use function count;
use function getdate;
use function key;

/**
 * Class ToolsTest
 *
 * @package Vicimus\Support\Tests\Unit
 */
class ToolsTest extends TestCase
{
    /**
     * Test years tools function.
     *
     * @return void
     */
    public function testLatestYears(): void
    {
        $years = Tools::latestYears();
        $this->assertEquals(20, count($years));

        $years = Tools::latestYears(2, 15);
        $this->assertEquals(15, count($years));
        $curYear = getdate()['year'];
        $this->assertEquals($curYear + 2, key($years));
    }

    /**
     * Test parse sale classes function.
     *
     * @return void
     */
    public function testParseVehicleSaleClass(): void
    {
        $result = Tools::parseVehicleSaleClass('used');
        $this->assertEquals('used', $result);

        $result = Tools::parseVehicleSaleClass('new');
        $this->assertEquals('new', $result);

        $result = Tools::parseVehicleSaleClass('usagee');
        $this->assertEquals('used', $result);

        $result = Tools::parseVehicleSaleClass('usagé');
        $this->assertEquals('used', $result);

        $result = Tools::parseVehicleSaleClass('usageefpowiej');
        $this->assertNull($result);

        $result = Tools::parseVehicleSaleClass('neuf');
        $this->assertEquals('new', $result);
    }

    /**
     * Test parse country function.
     *
     * @return void
     */
    public function testParseCountry(): void
    {
        $result = Tools::parseCountry('ca');
        $this->assertEquals('CA', $result);

        $result = Tools::parseCountry('Canada');
        $this->assertEquals('CA', $result);

        $result = Tools::parseCountry('USA');
        $this->assertEquals('US', $result);

        $result = Tools::parseCountry('US');
        $this->assertEquals('US', $result);

        $result = Tools::parseCountry('United-States');
        $this->assertEquals('US', $result);

        $result = Tools::parseCountry('United-States of America');
        $this->assertEquals('US', $result);
    }

    /**
     * Test parse language function.
     *
     * @return void
     */
    public function testParseLanguage(): void
    {
        $result = Tools::parseLanguage('en');
        $this->assertEquals('en', $result);

        $result = Tools::parseLanguage('fr');
        $this->assertEquals('fr', $result);

        $result = Tools::parseLanguage('english');
        $this->assertEquals('en', $result);

        $result = Tools::parseLanguage('français');
        $this->assertEquals('fr', $result);

        $result = Tools::parseLanguage('eng');
        $this->assertEquals('en', $result);

        $result = Tools::parseLanguage('fra');
        $this->assertEquals('fr', $result);
    }

    /**
     * Test parse mileage unit function.
     *
     * @return void
     */
    public function testParseMileageUnit(): void
    {
        $result = Tools::parseMileageUnit('km');
        $this->assertEquals('km', $result);

        $result = Tools::parseMileageUnit('mi');
        $this->assertEquals('mi', $result);

        $result = Tools::parseMileageUnit('miles');
        $this->assertEquals('mi', $result);

        $result = Tools::parseMileageUnit('kilometers');
        $this->assertEquals('km', $result);

        $result = Tools::parseMileageUnit('kilomètres');
        $this->assertEquals('km', $result);
    }

    /**
     * Test parse payment type function.
     *
     * @return void
     */
    public function testParsePaymentType(): void
    {
        $result = Tools::parsePaymentType('Cash');
        $this->assertEquals('cash', $result);

        $result = Tools::parsePaymentType('Lease');
        $this->assertEquals('lease', $result);

        $result = Tools::parsePaymentType('Financing');
        $this->assertEquals('finance', $result);

        $result = Tools::parsePaymentType('Comptant');
        $this->assertEquals('cash', $result);

        $result = Tools::parsePaymentType('location');
        $this->assertEquals('lease', $result);

        $result = Tools::parsePaymentType('Financement');
        $this->assertEquals('finance', $result);
    }

    /**
     * Test parse timezone function.
     *
     * @return void
     */
    public function testParseTimezone(): void
    {
        $result = Tools::parseTimezone('PST');
        $this->assertEquals('PST', $result);

        $result = Tools::parseTimezone('eastern');
        $this->assertEquals('EST', $result);

        $result = Tools::parseTimezone('Heure de l\'Atlantique');
        $this->assertEquals('ADT', $result);

        $result = Tools::parseTimezone('Mountain timezone');
        $this->assertEquals('MST', $result);
    }

    /**
     * Test parse state function.
     *
     * @return void
     */
    public function testParseState(): void
    {
        $result = Tools::parseState('Québec', 'CA');
        $this->assertEquals('QC', $result);

        $result = Tools::parseState('Ontario', 'CA');
        $this->assertEquals('ON', $result);

        $result = Tools::parseState('Alabama', 'US');
        $this->assertEquals('AL', $result);
    }

    /**
     * Test get country from state function.
     *
     * @return void
     */
    public function testGetCountryFromState(): void
    {
        $result = Tools::getCountryFromState('Québec');
        $this->assertEquals('CA', $result);

        $result = Tools::getCountryFromState('New York');
        $this->assertEquals('US', $result);

        $result = Tools::getCountryFromState('California');
        $this->assertEquals('US', $result);

        $result = Tools::getCountryFromState('CA');
        $this->assertEquals('US', $result);
    }

    /**
     * Test isCompany.
     *
     * @return void
     */
    public function testIsCompany(): void
    {
        $result = Tools::isCompany('John Deere inc.');
        $this->assertTrue($result);

        $result = Tools::isCompany('Planète Honda');
        $this->assertTrue($result);

        $result = Tools::isCompany('Parker Chrysler');
        $this->assertTrue($result);

        $result = Tools::isCompany('Mazda Canada');
        $this->assertTrue($result);

        $result = Tools::isCompany('Bell ltd');
        $this->assertTrue($result);

        $result = Tools::isCompany('Jean Gareau ltd');
        $this->assertTrue($result);

        $result = Tools::isCompany('Videotron corp');
        $this->assertTrue($result);

        $result = Tools::isCompany('Videotron limitée');
        $this->assertTrue($result);

        $result = Tools::isCompany('Jack Black and sons');
        $this->assertTrue($result);

        $result = Tools::isCompany('Jack Black & sons');
        $this->assertTrue($result);

        $result = Tools::isCompany('Jacques Demers et fils');
        $this->assertTrue($result);

        $result = Tools::isCompany('Joe Smith');
        $this->assertFalse($result);

        $result = Tools::isCompany('Jane Doe');
        $this->assertFalse($result);

        $result = Tools::isCompany('Jane');
        $this->assertFalse($result);
    }

    /**
     * Test detecting date format.
     *
     * @return void
     */
    public function testDetectDateFormat(): void
    {
        $dates = [
            '04/28/2008',
            '10/27/2008',
            '01/01/2008',
            '05/03/2013',
            '01/01/2014',
            '10/13/2016',
            '04/10/2017',
            '01/01/2006',
            '01/01/2003',
            '01/13/2012',
        ];

        $format = Tools::detectDateFormat($dates);
        $this->assertEquals('m/d/Y', $format);

        $dates = [
            '28-04-2008',
            '27-10-2008',
            '01-01-2008',
            '03-05-2013',
            '01-01-2014',
            '13-10-2016',
            '10-04-2017',
            '01-01-2006',
            '01-01-2003',
            '13-01-2012',
        ];

        $format = Tools::detectDateFormat($dates);
        $this->assertEquals('d-m-Y', $format);

        $dates = [
            '2008-04-28',
            '2008-10-27',
            '2008-01-01',
            '2013-05-03',
            '2014-01-01',
            '2016-10-13',
            '2017-04-10',
            '2006-01-01',
            '2003-01-01',
            '2012-01-13',
        ];

        $format = Tools::detectDateFormat($dates);
        $this->assertEquals('Y-m-d', $format);
    }
}
