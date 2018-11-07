<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Testing;

use Vicimus\Support\Testing\Application;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ApplicationTest
 */
class ApplicationTest extends TestCase
{
    /**
     * The application
     * @var Application
     */
    private $app;

    /**
     * Set the test up
     *
     * @return void
     */
    public function setup(): void
    {
        $this->app = new Application();
    }
}
