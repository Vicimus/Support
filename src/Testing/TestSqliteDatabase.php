<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

/**
 * Trait TestSqliteDatabase
 */
trait TestSqliteDatabase
{
    /**
     * Set up the databases
     *
     * @return void
     */
    public function setupDatabases(): void
    {
        $stub = database_path('stub.sqlite');
        $test = database_path('testing.sqlite');
        if (!($GLOBALS['setupDatabase'] ?? false)) {
            @unlink($stub);
            touch($stub);
            @unlink($test);
            touch($test);

            $this->artisan('migrate', [
                '--database' => 'stub',
            ]);

            $GLOBALS['setupDatabase'] = true;
        }

        copy($stub, $test);
    }
}
