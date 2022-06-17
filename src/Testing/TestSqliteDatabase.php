<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use Illuminate\Support\Facades\DB;
use Vicimus\Support\Classes\Benchmark;
use Vicimus\Support\Classes\NullOutput;
use Vicimus\Support\Classes\StandardOutput;
use Vicimus\Support\Exceptions\TestException;
use Vicimus\Support\Interfaces\ConsoleOutput;

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
     * @param string[] $aliases  Aliases for the main database
     *
     * @return void
     * @throws TestException
     */
    public function setupDatabases(string $path, array $external = [], array $aliases = []): void
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
                config()->set('database.connections.' . $code . '.database', $test);
            } else {
                foreach ($aliases as $alias) {
                    config()->set('database.connections.' . $alias . '.database', $test);
                    config()->set('database.connections.' . $alias . '.driver', 'sqlite');
                }
            }

            if (!($GLOBALS['setupDatabase'] ?? false)) {
                $this->doOneTimeSetup($database, $secondStub, $stub);
            }

            copy($secondStub, $test);

            if (!$database || isset($this->attached[$database])) {
                continue;
            }

            $attachment = sprintf('attach \'%s/%stesting.sqlite\' as %s', database_path(), $database, $code);
            DB::select($attachment);

            $this->attached[$database] = $code;
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
     *
     * @throws TestException
     *
     * @return void
     */
    private function doOneTimeSetup(?string $database, string $secondStub, string $stub): void
    {
        $output = $this->output();
        $bench = (new Benchmark())->init();
        if (!$this->isOutdated($database)) {
            copy(database_path('.cached'), $stub);
            $output->info(sprintf('Restored database from cache [%s]' . "\n", $bench->stop()->get()['time']));
            $this->finish($database, $stub, $secondStub);
            return;
        }

        if (!$database) {
            @unlink($secondStub);
            @unlink($stub);
            touch($stub);
        }

        if ($database) {
            copy($secondStub, $stub);
        }

        if (!$database) {
            $this->doMigration();
            file_put_contents(base_path('.vicimus.test.cache'), $this->checksum($database));
            copy($stub, database_path('.cached'));
            $bench->stop();
            $output->info(sprintf('One time database set up complete [%s]', $bench->get()['time']));
        }

        $this->finish($database, $stub, $secondStub);
    }

    /**
     * Get a migration checksum
     *
     * @param string|null $database The name of the database
     *
     * @return string
     */
    private function checksum(?string $database): ?string
    {
        if ($database) {
            return null;
        }

        $output = '';
        $size = '';

        if (file_exists(database_path('migrations'))) {
            exec(sprintf('find %s -type f', database_path('migrations')), $output);
            exec(sprintf('du -s %s', database_path('migrations')), $size);
        }

        return md5(json_encode($output) . json_encode($size));
    }

    /**
     * Finish set up
     *
     * @param string|null $database   The database
     * @param string      $stub       The stub
     * @param string      $secondStub The second stub
     *
     * @throws TestException
     *
     * @return void
     */
    private function finish(?string $database, string $stub, string $secondStub): void
    {
        copy($stub, $secondStub);
        if (!filesize($secondStub)) {
            throw new TestException('Database is 0 bytes, this is 99% an error');
        }

        if ($database) {
            return;
        }

        $GLOBALS['setupDatabase'] = true;
    }

    /**
     * Out dated
     *
     * @param string|null $database The database to check
     *
     * @return bool
     */
    private function isOutdated(?string $database): bool
    {
        $skip = (int) getenv('VICIMUS_TEST_NO_DATABASE_CACHE');
        if ($skip || !file_exists(base_path('.vicimus.test.cache'))) {
            return true;
        }

        return $this->checksum($database) !== file_get_contents(base_path('.vicimus.test.cache'));
    }

    /**
     * Get the output
     *
     * @return ConsoleOutput
     */
    private function output(): ConsoleOutput
    {
        $output = new NullOutput();
        $quiet = (int) getenv('VICIMUS_TEST_NO_DATABASE_OUTPUT');
        if (!$quiet) {
            $output = new StandardOutput();
        }

        return $output;
    }
}
