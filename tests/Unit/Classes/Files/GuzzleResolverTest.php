<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes\Files;

use ErrorException;
use GuzzleHttp\Psr7\Response;
use Throwable;
use Vicimus\Support\Classes\Files\GuzzleResolver;
use Vicimus\Support\Testing\GuzzleTestCase;

/**
 * Class GuzzleResolverTest
 */
class GuzzleResolverTest extends GuzzleTestCase
{
    /**
     * The resolver
     *
     * @var GuzzleResolver
     */
    private $instance;

    /**
     * Set the test up
     *
     * @return void
     */
    public function setup(): void
    {
        parent::setUp();

        $this->instance = new GuzzleResolver($this->guzzle([
            new Response(200, [], 'banana'),
        ]));
    }

    /**
     * Test open
     *
     * @return void
     *
     * @throws Throwable
     */
    public function testOpen(): void
    {
        $resource = $this->instance->open(__FILE__, 'rb');
        $this->assertIsResource($resource);
        fclose($resource);
    }

    /**
     * Test opening a remote file
     *
     * @return void
     *
     * @throws Throwable
     */
    public function testOpenRemote(): void
    {
        $resource = $this->instance->open('banana.jpg', 'rb');
        $this->assertIsResource($resource);
        fclose($resource);
    }

    /**
     * Remote exceptions
     *
     * @return void
     */
    public function testOpenRemoteException(): void
    {
        $this->instance = new GuzzleResolver($this->guzzle([
            new Response(404, [], 'Not found'),
        ]));

        try {
            $this->instance->open('strawberry', 'rb');
            $this->wasExpectingException(ErrorException::class);
        } catch (ErrorException $ex) {
            $this->assertStringContainsString('Not found', $ex->getMessage());
        }
    }
}
