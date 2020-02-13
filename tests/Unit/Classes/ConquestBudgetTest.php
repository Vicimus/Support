<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\ConquestBudget;

/**
 * Class ConquestBudgetTest
 */
class ConquestBudgetTest extends TestCase
{
    /**
     * Conquest budget
     *
     * @return void
     */
    public function testMake(): void
    {
        $budget = new ConquestBudget([]);
        $this->assertNull($budget->spend);
        $this->assertNull($budget->total);

        $budget->setSpend(500);
        $this->assertEquals(500, $budget->spend);
    }
}
