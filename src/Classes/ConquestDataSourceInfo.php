<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

/**
 * Class ConquestDataSourceInfo
 *
 * @property string  $name
 * @property string  $description
 * @property string  $class
 * @property string  $category
 * @property string[] $mediums
 */
class ConquestDataSourceInfo extends ImmutableObject
{
    /**
     * ConquestDataSourceInfo constructor.
     *
     * @param string                      $name        The name
     * @param string                      $description The description
     * @param string                      $class       The implementing class
     * @param string                      $category    The category
     * @param ConquestCompatibilityMatrix $matrix      The compatibility matrix
     * @param string[]                    $mediums     The supported medium types
     */
    public function __construct(
        string $name,
        string $description,
        string $class,
        string $category,
        ConquestCompatibilityMatrix $matrix,
        array $mediums
    ) {
        parent::__construct([
            'name' => $name,
            'description' => $description,
            'class' => $class,
            'category' => $category,
            'matrix' => $matrix,
            'mediums' => $mediums,
        ]);
    }
}
