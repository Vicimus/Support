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
     * @return bool
     */
    public function boot(LoggerInterface $logger): bool
    {
        if (app()->environment() !== 'production') {
            return false;
        }

        $this->ignore = config('queue.ignore-failures') ?? [];

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

        return true;
    }

    /**
     * Is ignored name
     *
     * @param string $job       The job
     * @param string $exception The exception
     *
     * @return string[]
     */
    private function isIgnoredItem(string $job, string $exception): array
    {
        $items = [];
        if (array_key_exists($job, $this->ignore)) {
            $items[] = $job;
        }

        if (array_key_exists($exception, $this->ignore)) {
            $items[] = $exception;
        }

        return $items;
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

        $keys = $this->isIgnoredItem($job, $exception);
        if (!count($keys)) {
            return false;
        }

        return $this->shouldIgnoreFromKeys($keys, $event);
    }

    /**
     * Check a series of keys
     *
     * @param string[]  $keys  The keys to check
     * @param JobFailed $event The event
     *
     * @return bool
     */
    private function shouldIgnoreFromKeys(array $keys, JobFailed $event): bool
    {
        foreach ($keys as $key) {
            $matches = $this->ignore[$key];
            if ($matches === '*') {
                return true;
            }

            if (!is_array($matches)) {
                $matches = [$matches];
            }

            if ($this->matchInArray($event, $matches)) {
                return true;
            }
        }

        return false;
    }
}
