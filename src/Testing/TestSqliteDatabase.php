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
    public function setupDatabases(string $path, array $external = []): void
    {
        $external['null'] = '';

        foreach ($external as $code => $database) {
            if ($database) {
                $database .= '_';
            }

            $stub = sprintf('%s/%sstub.sqlite', $path, $database);
            $secondStub = sprintf('%s/%sunsullied.sqlite', $path, $database);
            $test = sprintf('%s/%stesting.sqlite', $path, $database);
            if ($database) {
                config()->set('database.connections.'. $code .'.database', $test);
            }

            if (!($GLOBALS['setupDatabase'] ?? false)) {
                if (!$database) {
                    @unlink($secondStub);
                    @unlink($stub);
                    touch($stub);
                }

                if ($database) {
                    copy($secondStub, $stub);
                }

                @unlink($test);
                touch($test);

                if (!$database) {
                    $this->doMigration();
                }

                copy($stub, $secondStub);
                if (!filesize($secondStub)) {
                    throw new TestException('Database is 0 bytes, this is 99% an error');
                }

                $GLOBALS['setupDatabase'] = true;
            }

            copy($secondStub, $test);
        }
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
