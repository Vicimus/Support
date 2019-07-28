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
     * Ignore these errors
     * @var string[][]
     */
    private $ignore = [];

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

        $this->ignore = config('queue.ignore-failures');

        app('queue')->failing(function (JobFailed $event) use ($logger): void {
            if ($this->shouldIgnore($event)) {
                return;
            }

            $message = sprintf(
                '%s in file %s on line %s',
                $event->exception->getMessage(),
                $event->exception->getFile(),
                $event->exception->getLine()
            );

            $errorMessage = sprintf('%s failed. %s', $event->job->resolveName(), $message);
            $logger->critical($errorMessage);
        });
    }

    /**
     * Look for a match within an array
     *
     * @param JobFailed $event   The event
     * @param string[]  $matches The matches
     *
     * @return bool
     */
    private function matchInArray(JobFailed $event, array $matches): bool
    {
        $message = $event->exception->getMessage();
        foreach ($matches as $match) {
            if (stripos($message, $match) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Should ignore event
     *
     * @param JobFailed $event The failed event
     *
     * @return bool
     */
    private function shouldIgnore(JobFailed $event): bool
    {
        if (!in_array($event->job->resolveName(), $this->ignore, false)) {
            return false;
        }

        $matches = $this->ignore[$event->job->resolveName()];
        if ($matches === '*') {
            return true;
        }

        if (!is_array($matches)) {
            $matches = [$matches];
        }

        return $this->matchInArray($event, $matches);
    }
}
