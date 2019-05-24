<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Vicimus\Support\Classes\Properties\Validator;
use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\PropertyRecord;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ValidatorTest
 */
class ValidatorTest extends TestCase
{
    /**
     * Assert validate
     * @return void
     * @throws RestException
     */
    public function testValidate(): void
    {
        $provider = $this->basicMock(PropertyProvider::class);
        $property = $this->basicMock(PropertyRecord::class);
        $property->method('name')->willReturn('title');

        $service = new Validator();

        $this->assertFalse($service->validate($provider, $property, 'test'));
    }
}
