<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

/**
 * Interface TestMigration
 */
interface TestMigration
{
    /**
     * Up for migrations during tests
     *
     * @return void
     */
    public function testUp(): void;
}
