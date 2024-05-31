<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Vicimus\Support\Classes\ComplexValue;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ComplexValueTest
 */
class ComplexValueTest extends TestCase
{
    /**
     * Constructor test
     */
    public function testConstructor(): void
    {
        $complex = new ComplexValue(1, 'one', '<div>1!</div>');
        $this->assertSame(1, $complex->value);
        $this->assertSame('one', $complex->label);
        $this->assertNotNull($complex->additional);
    }
}
