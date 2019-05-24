<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Properties;

use Illuminate\Support\Facades\Validator as IllValidator;
use Shared\Exceptions\PropertyException;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\PropertyRecord;

/**
 * Validates properties
 */
class Validator extends Finder
{
    /**
     * Validate a property
     *
     * @param PropertyProvider $provider The property provider
     * @param PropertyRecord   $property The property to validate
     * @param mixed            $value    The value to validate
     *
     * @return void
     * @throws PropertyException
     */
    public function validate(PropertyProvider $provider, PropertyRecord $property, $value): void
    {
        $prop = $this->find($provider, $property);
        if (!$prop || !$prop->restrictions()) {
            return;
        }

        $this->check(['property' => $value], ['property' => $prop->restrictions()]);
    }

    /**
     * Validate the provided dates
     *
     * @param string[] $data  Data to validate
     * @param string[] $rules Rules to use
     *
     * @return void
     * @throws PropertyException
     */
    private function check(array $data, array $rules): void
    {
        $validator = IllValidator::make($data, $rules);
        if ($validator->fails()) {
            throw new PropertyException(
                json_encode($validator->errors()->all()),
                422
            );
        }
    }
}
