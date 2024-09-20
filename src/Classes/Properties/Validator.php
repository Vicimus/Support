<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Properties;

use Illuminate\Contracts\Validation\Factory;
use JsonException;
use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\PropertyRecord;

class Validator extends Finder
{
    private Factory $factory;

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
     * @throws RestException
     */
    public function validate(PropertyProvider $provider, PropertyRecord $property, mixed $value): bool
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
     * @throws RestException
     * @throws JsonException
     */
    private function check(array $data, array $rules): bool
    {
        $validator = $this->factory->make($data, $rules);

        if ($validator->fails()) {
            throw new RestException(
                json_encode($validator->errors()->all(), JSON_THROW_ON_ERROR),
                422
            );
        }

        return true;
    }
}
