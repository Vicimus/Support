<?php

namespace Vicimus\Support\Database;

use InvalidArgumentException;

class ModelFactory
{
    private $definitions = [];

    public function builder($class, $count = null)
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
    public function define($class, $closure)
    {
        $this->definitions[$class] = $closure;
    }

}
