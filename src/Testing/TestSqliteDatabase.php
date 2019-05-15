<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use Illuminate\Support\Facades\DB;
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
     * @var bool[]
     */
    private $attached = [];

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
     * @param string   $path     The path to your database storage
     * @param string[] $external A list of external databases
     *
     * @throws TestException
     *
     * @return void
     */
    public function setupDatabases(string $path, array $external = []): void
    {
        $external['null'] = '';
        $external = array_reverse($external);

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
                $this->doOneTimeSetup($database, $secondStub, $stub, $test);
            }

            copy($secondStub, $test);

            if (!$database || isset($this->attached[$database])) {
                continue;
            }

            $attachment = sprintf('attach \'%s/%stesting.sqlite\' as %s', database_path(), $database, $code);
            DB::select($attachment);

            $this->attached[$database] = true;
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

    /**
     * Do the one time setup of the database
     *
     * @param string $database   The database
     * @param string $secondStub The second stub
     * @param string $stub       The first stub
     * @param string $test       The test path
     *
     * @throws TestException
     *
     * @return void
     */
    private function doOneTimeSetup(?string $database, string $secondStub, string $stub, string $test): void
    {
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

        if ($database) {
            return;
        }

        $GLOBALS['setupDatabase'] = true;
    }
}
