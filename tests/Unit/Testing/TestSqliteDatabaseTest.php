<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Testing;

use Illuminate\Support\Facades\Facade;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\MockObject\MockObject;
use Vicimus\Support\Exceptions\TestException;
use Vicimus\Support\Testing\Application;
use Vicimus\Support\Testing\TestCase;
use Vicimus\Support\Testing\TestSqliteDatabase;

/**
 * Class TestSqliteDatabaseTest
 */
class TestSqliteDatabaseTest extends TestCase
{
    /**
     * Set the test up
     *
     */
    public function setup(): void
    {
        vfsStream::setup('root');
        $app = new Application();
        Facade::setFacadeApplication($app);

        $app->bind('path.base', static fn () => __DIR__ . '/../../../resources/testing');

        $app->bind('path.database', static fn () => __DIR__ . '/../../../resources/testing');

        putenv('VICIMUS_TEST_NO_DATABASE_OUTPUT=1');
    }

    /**
     * Test setup
     *
     */
    public function testSetup(): void
    {
        /** @var TestSqliteDatabase|MockObject $mock */
        $mock = $this->getMockForTrait(TestSqliteDatabase::class);
        $mock->setMigration(static function ($reference): void {
            //
        });

        try {
            $mock->setupDatabases(vfsStream::url('root'));
        } catch (TestException $ex) {
            // This is just for testing
        }

        $this->assertFileExists(vfsStream::url('root/stub.sqlite'));
    }

    public function testTestCaseExtending(): void
    {
        $instance = new class extends TestCase
        {
            use TestSqliteDatabase;

            public function __construct()
            {
                parent::__construct('TestCaseExtending');
            }
        };

        $this->assertNotNull($instance);
    }
}
