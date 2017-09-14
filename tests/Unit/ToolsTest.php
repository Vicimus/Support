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
