<?php

namespace Vicimus\Support\Database;

use Faker\Factory;
use Illuminate\Support\Collection;

class ModelFactoryBuilder
{
    private $class;
    private $count;

    /**
     * The callable definition
     * @var callable
     */
    private $definition;

    public function __construct($definition, $class, $count)
    {
        $this->class = $class;
        $this->count = $count ?: 1;
        $this->definition = $definition;
    }

    /**
     * @param array $params
     *
     * @return Collection|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $params = [])
    {
        $class = $this->class;
        $definition = $this->definition;
        $results = [];
        for ($i = 0; $i < $this->count; $i++) {
            $results[] = $class::create(array_merge($definition(Factory::create()), $params));
        }

        if ($this->count === 1) {
            return $results[0];
        }

        return new Collection($results);
    }
}
