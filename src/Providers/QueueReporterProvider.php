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
     * Is ignored name
     *
     * @param string $job       The job
     * @param string $exception The exception
     *
     * @return string|null
     */
    private function isIgnoredItem(string $job, string $exception): ?string
    {
        if (in_array($job, $this->ignore, false)) {
            return $job;
        }

        if (in_array($exception, $this->ignore, false)) {
            return $exception;
        }

        return null;
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
        $job = $event->job->resolveName();
        $exception = get_class($event->exception);

        $key = $this->isIgnoredItem($job, $exception);
        if ($key === null) {
            return false;
        }

        $matches = $this->ignore[$key];
        if ($matches === '*') {
            return true;
        }

        if (!is_array($matches)) {
            $matches = [$matches];
        }

        return $this->matchInArray($event, $matches);
    }
}
