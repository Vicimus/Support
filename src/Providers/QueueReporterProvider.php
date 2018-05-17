<?php declare(strict_types = 1);

namespace Vicimus\Support\Providers;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

/**
 * Class QueueReporterProvider
 *
 * Offers helpful things for application involving queues, to reduce
 * repetitive code
 */
class QueueReporterProvider extends ServiceProvider
{
    /**
     * Boot
     *
     * @return void
     */
    public function boot(): void
    {
        if (app()->environment() !== 'production') {
            return;
        }

        app('queue')->failing(function (JobFailed $event): void {
            $message = sprintf(
                '%s in file %s on line %s',
                $event->exception->getMessage(),
                $event->exception->getFile(),
                $event->exception->getLine()
            );

            $errorMessage = sprintf('%s failed. %s', $event->job->resolveName(), $message);
            Log::critical($errorMessage);
        });
    }
}
