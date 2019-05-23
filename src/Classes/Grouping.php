<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

/**
 * Class Grouping
 *
 * A container for items (class names/slugs) and their associated property slugs
 *
 * @property string[] $items
 * @property string[] $properties
 */
class Grouping extends ImmutableObject
{
    /**
     * AssetGrouping constructor
     *
     * @param string[] $items      The items belonging to the group
     * @param string[] $properties Properties for the group
     */
    public function __construct(array $items = [], array $properties = [])
    {
        parent::__construct([
            'items' => $items,
            'properties' => $properties,
        ]);
    }
}
