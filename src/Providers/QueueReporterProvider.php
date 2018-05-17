<?php declare(strict_types = 1);

namespace Vicimus\Support\Providers;

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

        $channel = new Channel(
            $this->app->make(Client::class),
            'https://hooks.slack.com/services/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',
            '33c01757-5f50-2d06-ecd9-502b11de8ab7'
        );

        Queue::failing(function (JobFailed $event) use ($channel): void {
            $message = sprintf(
                '%s in file %s on line %s',
                $event->exception->getMessage(),
                $event->exception->getFile(),
                $event->exception->getLine()
            );

            $channel->error($event->job->resolveName() . ' failed', 'Job Failure', $message);
        });
    }
}
