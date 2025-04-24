<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Locale;

use Vicimus\Support\Locale\Compiler;
use Vicimus\Support\Testing\TestCase;

class CompilerTest extends TestCase
{
    public function testCompile(): void
    {
        $compiler = new Compiler(__DIR__ . '/../../../resources/testing/lang');
        $translations = $compiler->get('en');

        $this->assertArrayHasKey('hello', $translations);
        $this->assertEquals('Hello', $translations['hello']);

        $this->assertArrayHasKey('fruit', $translations);
        $this->assertIsArray($translations['fruit']);

        $this->assertArrayHasKey('banana', $translations['fruit']);
        $this->assertEquals('Banana', $translations['fruit']['banana']);

        $this->assertArrayHasKey('strawberry', $translations['fruit']);
        $this->assertEquals('Strawberry', $translations['fruit']['strawberry']);

        $french = $compiler->get('fr-CA');
        $this->assertArrayHasKey('hello', $french);
        $this->assertEquals('Bonjour', $french['hello']);
        $this->assertArrayHasKey('fruit', $french);
        $this->assertIsArray($french['fruit']);

        $this->assertArrayHasKey('banana', $french['fruit']);
        $this->assertEquals('French for banana', $french['fruit']['banana']);
    }
}
