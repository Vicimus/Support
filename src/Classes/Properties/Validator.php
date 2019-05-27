<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Properties;

use Illuminate\Contracts\Validation\Factory;
use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\PropertyRecord;

/**
 * Validates properties
 */
class Validator extends Finder
{
    /**
     * Illuminate validator
     * @var Factory
     */
    private $factory;

    /**
     * Validator constructor
     *
     * @param Factory $factory Illuminate validator
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Validate a property
     *
     * @param PropertyProvider $provider The property provider
     * @param PropertyRecord   $property The property to validate
     * @param mixed            $value    The value to validate
     *
     * @return void
     * @throws RestException
     */
    public function validate(PropertyProvider $provider, PropertyRecord $property, $value): bool
    {
        $prop = $this->find($provider, $property);
        if (!$prop || !$prop->restrictions()) {
            return false;
        }

        return $this->check(['property' => $value], ['property' => $prop->restrictions()]);
    }

    /**
     * Validate the provided dates
     *
     * @param string[] $data  Data to validate
     * @param string[] $rules Rules to use
     *
     * @return void
     * @throws RestException
     */
    private function check(array $data, array $rules): bool
    {
        $validator = $this->factory->make($data, $rules);

        if ($validator->fails()) {
            throw new RestException(
                json_encode($validator->errors()->all()),
                422
            );
        }

        return true;
    }
}
