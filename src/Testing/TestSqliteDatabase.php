<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use RMS\Models\Campaign;

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
        $secondStub = database_path('unsullied.sqlite');

        $test = database_path('testing.sqlite');

        if (!($GLOBALS['setupDatabase'] ?? false)) {
            @unlink($secondStub);
            @unlink($stub);
            touch($stub);
            @unlink($test);
            touch($test);

            $this->artisan('migrate', [
                '--database' => 'stub',
            ]);

            copy($stub, $secondStub);

            $GLOBALS['setupDatabase'] = true;
        }

        copy($secondStub, $test);
    }
}
