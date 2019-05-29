<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\MarketingSuite\ConquestDataSource;

/**
 * Class ConquestCompatibility
 *
 * @property string $class
 * @property string $name
 * @property string $description
 */
class ConquestCompatibility extends ImmutableObject
{
    /**
     * ConquestCompatibility constructor.
     *
     * @param string $class       The class
     * @param string $description The description
     */
    public function __construct(string $class, string $description = '')
    {
        /** @var ConquestDataSource $instance */
        $instance = new $class();

        parent::__construct([
            'class' => $class,
            'name' => $instance->name(),
            'description' => $description,
        ]);
    }
}
