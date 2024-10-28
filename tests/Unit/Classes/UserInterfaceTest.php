<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\UserInterface;

/**
 * Class TimerTest
 */
class UserInterfaceTest extends TestCase
{
    /**
     * Assert extracting dependency node from file
     */
    public function testDependancies(): void
    {
        $ui = new UserInterface();
        $path = __DIR__ . '/../../../resources/testing/dependencies.json';
        $dependencies = $ui->parseNodeDependencies($path);

        $this->assertCount(1, $dependencies);
        $this->assertArrayHasKey('one', $dependencies);
        $this->assertSame(1, $dependencies['one']);

        $public = $ui->publicDependencies(['public1' => 'one']);
        $this->assertCount(1, $public);
        $this->assertArrayHasKey('public1', $public);
        $this->assertSame('one', $public['public1']);

        $this->assertSame($public, $ui->public);
    }
}
