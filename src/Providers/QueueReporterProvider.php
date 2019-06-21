<?php declare(strict_types = 1);

namespace Vicimus\Support\Providers;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

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
     * @param LoggerInterface $logger The application logger
     *
     * @return void
     */
    public function boot(LoggerInterface $logger): void
    {
        if (app()->environment() !== 'production') {
            return;
        }

        app('queue')->failing(static function (JobFailed $event) use ($logger): void {
            $message = sprintf(
                '%s in file %s on line %s with payload %s',
                $event->exception->getMessage(),
                $event->exception->getFile(),
                $event->exception->getLine(),
                json_encode($event->job->payload())
            );

            $errorMessage = sprintf('%s failed. %s', $event->job->resolveName(), $message);
            $logger->critical($errorMessage);
        });
    }
}
