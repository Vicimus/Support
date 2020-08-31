<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Vicimus\AssetBuilder\Classes\AssetProperty;
use Vicimus\Support\Exceptions\InvalidArgumentException;
use Vicimus\Support\Interfaces\MarketingSuite\Campaign;
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
     * phpcs:disable
     *
     * @param string[]   $items      The items belonging to the group
     * @param Property[] $properties Properties for the group
     */
    public function __construct(array $items = [], array $properties = [])
    {
        // phpcs:enable
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
     * On update allows extending classes to implement some code when
     * something on the group is updated
     *
     * @param Campaign $campaign The campaign
     * @param mixed[]  $payload  The parameters that were updated
     *
     * @return void
     */
    public function onUpdate(Campaign $campaign, array $payload): void
    {
        //
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

    /**
     * Parse the constant properties and convert them into AssetProperty instances
     *
     * @param string[]|string[][] $properties The properties
     *
     * @return AssetProperty[]
     */
    protected function parse(array $properties): array
    {
        $payload = [];
        foreach ($properties as $property => $info) {
            $info['property'] = $property;
            $payload[] = new AssetProperty($info);
        }

        return $payload;
    }
}
