<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Illuminate\Contracts\Validation\Validator as IllValidator;
use Illuminate\Support\Collection;
use Illuminate\Validation\Factory;
use Vicimus\Support\Classes\Properties\Validator;
use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\Property;
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
    public function testValidateInvalid(): void
    {
        $providerProp = $this->basicMock(Property::class);
        $providerProp->method('property')->willReturn('title');
        $providerProp->method('restrictions')->willReturn('required');

        $provider = $this->basicMock(PropertyProvider::class);
        $provider->method('properties')->willReturn([$providerProp]);

        $property = $this->basicMock(PropertyRecord::class);
        $property->method('name')->willReturn('title');

        $validator = $this->basicMock(IllValidator::class);
        $validator->method('fails')->willReturn(true);
        $validator->method('errors')->willReturn(new Collection('title is required'));

        $factory = $this->basicMock(Factory::class);
        $factory->method('make')->willReturn($validator);
        $service = new Validator($factory);

        try {
            $service->validate($provider, $property, 'test');
            $this->fail('Validator exception not thrown');
        } catch (RestException $ex) {
            $this->assertSame(422, $ex->getCode());
        }
    }
    /**
     * Assert validate
     * @return void
     * @throws RestException
     */
    public function testValidateValid(): void
    {
        $providerProp = $this->basicMock(Property::class);
        $providerProp->method('property')->willReturn('title');
        $providerProp->method('restrictions')->willReturn('required');

        $provider = $this->basicMock(PropertyProvider::class);
        $provider->method('properties')->willReturn([$providerProp]);

        $property = $this->basicMock(PropertyRecord::class);
        $property->method('name')->willReturn('title');

        $validator = $this->basicMock(IllValidator::class);
        $validator->method('fails')->willReturn(false);

        $factory = $this->basicMock(Factory::class);
        $factory->method('make')->willReturn($validator);
        $service = new Validator($factory);

        $this->assertTrue($service->validate($provider, $property, 'test'));
    }

    /**
     * Assert validate
     * @return void
     * @throws RestException
     */
    public function testValidateSkipped(): void
    {
        $provider = $this->basicMock(PropertyProvider::class);
        $property = $this->basicMock(PropertyRecord::class);
        $property->method('name')->willReturn('title');

        $factory = $this->basicMock(Factory::class);
        $service = new Validator($factory);

        $this->assertFalse($service->validate($provider, $property, 'test'));
    }
}
