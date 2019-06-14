<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use InvalidArgumentException;
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
     *
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
            'assets' => array_values($instance->assets()),
            'class' => $class,
            'name' => $instance->name(),
            'description' => $description,
        ]);
    }
}
