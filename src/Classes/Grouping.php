<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Exceptions\InvalidArgumentException;
use Vicimus\Support\Interfaces\Property;

/**
 * Class Grouping
 *
 * A container for items (class names/slugs) and their associated property slugs
 *
 * @property string[] $items
 * @property Property[] $properties
 */
class Grouping extends ImmutableObject
{
    /**
     * AssetGrouping constructor
     *
     * @param string[]   $items      The items belonging to the group
     * @param Property[] $properties Properties for the group
     */
    public function __construct(array $items = [], array $properties = [])
    {
        foreach ($properties as $property) {
            if (!$property instanceof Property) {
                throw new InvalidArgumentException($property, Property::class);
            }
        }

        parent::__construct([
            'items' => $items,
            'properties' => $properties,
        ]);
    }

    /**
     * Access a groupings property
     *
     * @param string $property The property name to retrieve
     *
     * @return Property
     */
    public function property(string $property): ?Property
    {
        foreach ($this->properties as $prop) {
            if ($prop->property() === $property) {
                return $prop;
            }
        }

        return null;
    }
}
