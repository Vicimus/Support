<?php declare(strict_types = 1);

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
     * @return void
     */
    public function testCall(): void
    {
        $utility = new GenericUtility(
            'Test Utility',
            'This is used to test it\'s functionality',
            static function (?array $flags): string {
                return $flags['fruit'] ?? 'banana';
            }
        );

        $this->assertEquals('banana', $utility->call());
        $this->assertEquals('strawberry', $utility->call(['fruit' => 'strawberry']));
    }

    /**
     * Test the name
     *
     * @return void
     */
    public function testName(): void
    {
        $utility = new GenericUtility(
            'Test Utility',
            'This is used to test it\'s functionality',
            static function (?array $flags): string {
                return $flags['fruit'] ?? 'banana';
            }
        );

        $this->assertEquals('Test Utility', $utility->name());
    }

    /**
     * Test the description
     *
     * @return void
     */
    public function testDescription(): void
    {
        $utility = new GenericUtility(
            'Test Utility',
            'This is used to test it\'s functionality',
            static function (?array $flags): string {
                return $flags['fruit'] ?? 'banana';
            }
        );

        $this->assertEquals('This is used to test it\'s functionality', $utility->description());
    }

    /**
     * Ensure a crash is caught and thrown as expected
     *
     * @return void
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
}
