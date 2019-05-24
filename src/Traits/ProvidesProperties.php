<?php declare(strict_types = 1);

namespace Vicimus\Support\Traits;

use Illuminate\Support\Facades\Validator;
use Shared\Exceptions\PropertyException;
use Vicimus\AssetBuilder\Classes\AssetProperty;
use Vicimus\Support\Interfaces\Property;
use Vicimus\Support\Interfaces\PropertyRecord;

/**
 * Provides properties
 */
trait ProvidesProperties
{

    /**
     * Validate a property
     *
     * @param PropertyRecord $property The property to validate
     * @param mixed          $value    The value to validate
     *
     * @return void
     * @throws PropertyException
     */
    public function validate(PropertyRecord $property, $value): void
    {
        $prop = $this->findProperty($property);
        if (!$prop || !$prop->restrictions()) {
            return;
        }

        $this->check(['property' => $value], ['property' => $prop->restrictions()]);
    }

    /**
     * Retrieve the possible values a property can have
     *
     * @param PropertyRecord $property The property to check
     * @return mixed[]
     */
    public function values(PropertyRecord $property): array
    {
        $prop = $this->findProperty($property);
        return ($prop) ? $prop->values() : [];
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
    protected function check(array $data, array $rules): void
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new PropertyException(
                json_encode($validator->errors()->all()),
                422
            );
        }
    }

    /**
     * Find the provided property from the source
     *
     * @param PropertyRecord $property Property to search for
     * @return Property|null
     *
     * @todo
     * - Does this need access to the asset owning the property to see if its a part of the grouping
     * - Should a source provide multiple groupings
     */
    protected function findProperty(PropertyRecord $property): ?Property
    {
        /** @var AssetProperty $prop */
        foreach ($this->properties() as $prop) {
            if ($prop->property !== $property->name()) {
                continue;
            }

            return $prop;
        }

        return null;
    }
}
