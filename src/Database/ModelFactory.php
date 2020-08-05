<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use InvalidArgumentException;

/**
 * Class ModelFactory
 */
class ModelFactory
{
    /**
     * The definitions
     * @var callable[]|array
     */
    private $definitions = [];

    /**
     * Get the builder for a class
     *
     * @param string   $class The class
     * @param int|null $count The number to make
     *
     * @return ModelFactoryBuilder
     *
     * @throws InvalidArgumentException
     */
    public function builder(string $class, ?int $count = null): ModelFactoryBuilder
    {
        if (!isset($this->definitions[$class])) {
            throw new InvalidArgumentException(sprintf('No definition found for [%s]', $class));
        }

        return new ModelFactoryBuilder($this->definitions[$class], $class, $count);
    }

    /**
     * Define a factory for a class
     *
     * @param string   $class   The class to define
     * @param callable $closure The callable must return an array
     *
     * @return void
     */
    public function define(string $class, callable $closure): void
    {
        $this->definitions[$class] = $closure;
    }
}
