<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Illuminate\Contracts\View\View;
use Vicimus\Support\Classes\ConquestCompatibilityMatrix;
use Vicimus\Support\Interfaces\MarketingSuite\ConquestDataSource;
use Vicimus\Support\Interfaces\MarketingSuite\ConquestDataSourceRepository;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ConquestCompatibilityMatrixTest
 */
class ConquestCompatibilityMatrixTest extends TestCase
{
    /**
     * Constructor test
     *
     */
    public function testConstructor(): void
    {
        $repo = $this->basicMock(ConquestDataSourceRepository::class);
        $repo->method('isRegistered')
            ->willReturnOnConsecutiveCalls(true, false);

        app()->bind(ConquestDataSourceRepository::class, static fn () => $repo);

        $matrix = new ConquestCompatibilityMatrix();
        $this->assertCount(0, $matrix->matrix);

        $view = $this->basicMock(View::class);
        $view->method('render')
            ->willReturn('strawberry');

        $mock = $this->basicMock(ConquestDataSource::class);
        $matrix = new ConquestCompatibilityMatrix([
            'not-valid' => 'not there',
            $mock::class => $view,
        ]);

        $matrix->add([$mock::class => 'another']);

        $this->assertCount(1, $matrix->matrix);

        $payload = $matrix->toArray();
        $this->assertCount(1, $payload);
    }
}
