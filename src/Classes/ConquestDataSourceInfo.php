<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

/**
 * Class ConquestDataSourceInfo
 *
 * @property string                      $name
 * @property string                      $description
 * @property string                      $class
 * @property string                      $category
 * @property ConquestCompatibilityMatrix $matrix
 * @property string[]                    $mediums
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
     * @param string                      $icon        The source icon
     */
    public function __construct(
        string $name,
        string $description,
        string $class,
        string $category,
        ConquestCompatibilityMatrix $matrix,
        array $mediums,
        string $icon
    ) {
        parent::__construct([
            'name' => $name,
            'description' => $description,
            'class' => $class,
            'category' => $category,
            'matrix' => $matrix,
            'mediums' => $mediums,
            'icon' => $icon,
        ]);
    }

    /**
     * Set the details
     *
     * @param object|string[][] $details Details object
     *
     * @return void
     */
    public function setDetails($details): void
    {
        $this->attributes['details'] = $details;
    }

    /**
     * Set the error message
     *
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->attributes['error'] = $error;
    }

    /**
     * Set verification details
     *
     * @param object $verify The verification object
     *
     * @return void
     */
    public function setVerification(object $verify): void
    {
        $this->attributes['verification'] = $verify;
        unset($this->attributes['verification']['store']);
    }
}
