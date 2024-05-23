<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Providers;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Facade;
use Psr\Log\LoggerInterface;
use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Providers\QueueReporterProvider;
use Vicimus\Support\Testing\Application;
use Vicimus\Support\Testing\TestCase;

/**
 * Class QueueReporterProviderTest
 */
class QueueReporterProviderTest extends TestCase
{
    /**
     * The queue reporter provider
     *
     */
    private QueueReporterProvider $reporter;

    /**
     * Set up
     */
    public function setup(): void
    {
        parent::setup();

        Facade::clearResolvedInstances();

        $app = new Application();
        Facade::setFacadeApplication($app);

        app()->setEnvironment('production');

        $app->singleton('config', static function () {
            $config = new ConfigRepository([]);
            $config->set('view.paths', []);
            $config->set('view.compiled', __DIR__ . '../../../resources/testing/views');
            $config->set('auth.driver', 'eloquent');
            return $config;
        });

        $app->singleton('queue', function () {
            /* phpcs:disable */
            $queue = new class {
                /**
                 * Closures
                 * @var callable[]
                 */
                private $closures = [];

                /**
                 * Failing
                 * @param callable $closure Closure
                 *
                 * @return void
                 */
                public function failing(callable $closure): void
                {
                    $this->closures[] = $closure;
                }

                /**
                 * Execute a fail
                 *
                 * @param JobFailed $failed The job failure
                 *
                 * @return void
                 */
                public function fail(JobFailed $failed): void
                {
                    foreach ($this->closures as $closure) {
                        $closure($failed);
                    }
                }
            };

            return $queue;
        });

        /* phpcs:enable */

        $this->reporter = new QueueReporterProvider($app);
    }

    /**
     * Test failing
     *
     */
    public function testFailing(): void
    {
        $logger = $this->basicMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('critical');

        $this->reporter->boot($logger);

        $queue = app('queue');

        $job = $this->basicMock(Job::class);
        $job->method('resolveName')
            ->willReturn('ProspectToken');
        $queue->fail(new JobFailed('banana', $job, new RestException('Bad thing', 422)));
    }

    /**
     * This should not be logged
     *
     */
    public function testFailingIgnoredJob(): void
    {
        $logger = $this->basicMock(LoggerInterface::class);
        $logger->expects($this->never())
            ->method('critical');

        config()->set('queue.ignore-failures', [
            'ProspectToken' => 'thing',
        ]);

        $this->reporter->boot($logger);

        $queue = app('queue');

        $job = $this->basicMock(Job::class);
        $job->method('resolveName')
            ->willReturn('ProspectToken');

        $queue->fail(new JobFailed('banana', $job, new RestException('Bad thing', 422)));
    }

    /**
     * This should not be logged
     *
     */
    public function testFailingIgnoredJobWithSpecificMessage(): void
    {
        $this->reporter = new QueueReporterProvider(app());

        $logger = $this->basicMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('critical');

        config()->set('queue.ignore-failures', [
            'ProspectToken' => 'Strawberries',
        ]);

        $this->reporter->boot($logger);

        $queue = app('queue');

        $job = $this->basicMock(Job::class);
        $job->method('resolveName')
            ->willReturn('ProspectToken');

        $queue->fail(new JobFailed('banana', $job, new RestException('Bad thing', 422)));
    }

    /**
     * This should not be logged
     *
     */
    public function testFailingIgnoredJobWithWildcard(): void
    {
        $this->reporter = new QueueReporterProvider(app());

        $logger = $this->basicMock(LoggerInterface::class);
        $logger->expects($this->never())
            ->method('critical');

        config()->set('queue.ignore-failures', [
            'ProspectToken' => '*',
        ]);

        $this->reporter->boot($logger);

        $queue = app('queue');

        $job = $this->basicMock(Job::class);
        $job->method('resolveName')
            ->willReturn('ProspectToken');

        $queue->fail(new JobFailed('banana', $job, new RestException('marshmallows', 422)));
    }

    /**
     * Exceptions work too
     *
     */
    public function testFailingIgnoredException(): void
    {
        $this->reporter = new QueueReporterProvider(app());

        $logger = $this->basicMock(LoggerInterface::class);
        $logger->expects($this->never())
            ->method('critical');

        config()->set('queue.ignore-failures', [
            'ProspectToken' => 'Strawberries',
            RestException::class => ['apples', 'Bad'],
        ]);

        $this->reporter->boot($logger);

        $queue = app('queue');

        $job = $this->basicMock(Job::class);
        $job->method('resolveName')
            ->willReturn('ProspectToken');

        $queue->fail(new JobFailed('banana', $job, new RestException('Bad thing', 422)));
    }

    /**
     * If not production ensure we don't do stuff
     *
     */
    public function testBootOnlyInProduction(): void
    {
        Facade::clearResolvedInstances();

        $app = new Application();
        Facade::setFacadeApplication($app);

        app()->setEnvironment('develop');

        $logger = $this->basicMock(LoggerInterface::class);

        $reporter = new QueueReporterProvider($app);
        $this->assertFalse($reporter->boot($logger));
    }
}
