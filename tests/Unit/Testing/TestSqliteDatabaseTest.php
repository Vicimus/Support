<?php declare(strict_types = 1);

namespace Vicimus\Support\Unit\Testing;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\MockObject\MockObject;
use Vicimus\Support\Exceptions\TestException;
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
     * @return void
     */
    public function setup(): void
    {
        vfsStream::setup('root');
    }
    /**
     * Test setup
     *
     * @return void
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

        $this->assertFileExists(vfsStream::url('root/testing.sqlite'));
    }
}
