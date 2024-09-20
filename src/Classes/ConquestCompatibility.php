<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use InvalidArgumentException;
use Vicimus\Support\Interfaces\MarketingSuite\ConquestDataSource;

/**
 * @property string   $class
 * @property string   $name
 * @property string   $description
 * @property string[] $mediums
 */
class ConquestCompatibility extends ImmutableObject
{
    /**
     * ConquestCompatibility constructor.
     * @throws InvalidArgumentException
     */
    public function __construct(string $class, string $description = '')
    {
        /** @var ConquestDataSource $instance */
        $instance = app($class);
        if (!$instance instanceof ConquestDataSource) {
            throw new InvalidArgumentException(sprintf(
                'Class passed must implement [%s]. Received [%s]',
                ConquestDataSource::class,
                $class
            ));
        }

        parent::__construct([
            'class' => $class,
            'mediums' => array_values($instance->assets()),
            'name' => $instance->name(),
            'description' => $description,
        ]);
    }
}
