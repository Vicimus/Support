<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use Vicimus\Support\Exceptions\TestException;

/**
 * Trait TestSqliteDatabase
 */
trait TestSqliteDatabase
{
    /**
     * How we migrate
     *
     * @var callable
     */
    protected $migrate;

    /**
     * Set how we migrate the databases
     *
     * @param callable $migrate The migration callable
     *
     * @return self
     */
    public function setMigration(callable $migrate): self
    {
        $this->migrate = $migrate;
        return $this;
    }

    /**
     * Set up the databases
     *
     * @param string $path The path to your database storage
     *
     * @throws TestException
     *
     * @return void
     */
    public function setupDatabases(string $path): void
    {
        $stub = $path . '/stub.sqlite';
        $secondStub = $path . '/unsullied.sqlite';

        $test = $path . '/testing.sqlite';

        if (!($GLOBALS['setupDatabase'] ?? false)) {
            @unlink($secondStub);
            @unlink($stub);
            touch($stub);
            @unlink($test);
            touch($test);

            $this->doMigration();

            copy($stub, $secondStub);
            if (!filesize($secondStub)) {
                throw new TestException('Database is 0 bytes, this is 99% an error');
            }

            $GLOBALS['setupDatabase'] = true;
        }

        copy($secondStub, $test);
    }

    /**
     * Execute the migration
     *
     * @return void
     */
    protected function doMigration(): void
    {
        $callable = $this->migrate;
        $callable($this);
    }
}