<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Tools;
use function count;
use function getdate;
use function key;

/**
 * Class ToolsTest
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

        $result = Tools::getCountryFromState('BANANA');
        $this->assertNull($result);
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

        $result = Tools::isCompany('voided');
        $this->assertFalse($result);

        $result = Tools::isCompany('family');
        $this->assertFalse($result);

        $result = Tools::isCompany('trust');
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

        $this->assertNull(Tools::detectDateFormat([]));
    }
}
