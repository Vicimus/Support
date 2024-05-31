<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Exception;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\GenericUtility;
use Vicimus\Support\Exceptions\UtilityException;

/**
 * Class GenericUtilityTest
 */
class GenericUtilityTest extends TestCase
{
    /**
     * Test calling the utility
     *
     */
    public function testCall(): void
    {
        $utility = new GenericUtility(
            'Test Utility',
            'This is used to test it\'s functionality',
            static fn (?array $flags): string => $flags['fruit'] ?? 'banana'
        );

        $this->assertEquals('banana', $utility->call());
        $this->assertEquals('strawberry', $utility->call(['fruit' => 'strawberry']));
    }

    /**
     * Test the name
     *
     */
    public function testName(): void
    {
        $utility = new GenericUtility(
            'Test Utility',
            'This is used to test it\'s functionality',
            static fn (?array $flags): string => $flags['fruit'] ?? 'banana'
        );

        $this->assertEquals('Test Utility', $utility->name());
    }

    /**
     * Test the description
     *
     */
    public function testDescription(): void
    {
        $utility = new GenericUtility(
            'Test Utility',
            'This is used to test it\'s functionality',
            static fn (?array $flags): string => $flags['fruit'] ?? 'banana'
        );

        $this->assertEquals('This is used to test it\'s functionality', $utility->description());
    }

    /**
     * Ensure a crash is caught and thrown as expected
     *
     */
    public function testStupidCall(): void
    {
        $utility = new GenericUtility(
            'Test Utility',
            'This is used to test it\'s functionality',
            static function (?array $flags): void {
                throw new Exception('Something bad happened');
            }
        );

        try {
            $utility->call();
        } catch (UtilityException $ex) {
            $this->assertStringContainsString('threw an exception', $ex->getMessage());
        }
    }

    /**
     * Test prompt
     */
    public function testPrompt(): void
    {
        $utility = new GenericUtility('Test Utility', 'Testing', static function (): void {
            //
        });
        $this->assertEquals('', $utility->prompt());
    }
}
