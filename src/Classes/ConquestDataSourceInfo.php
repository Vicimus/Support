<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

/**
 * Class ConquestDataSourceInfo
 *
 * @property string $name
 * @property string $description
 * @property string $class
 * @property string $category
 */
class ConquestDataSourceInfo extends ImmutableObject
{
    /**
     * ConquestDataSourceInfo constructor.
     *
     * @param string $name        The name
     * @param string $description The description
     * @param string $class       The implementing class
     * @param string $category    The category
     */
    public function __construct(string $name, string $description, string $class, string $category)
    {
        parent::__construct([
            'name' => $name,
            'description' => $description,
            'class' => $class,
            'category' => $category,
        ]);
    }
}
