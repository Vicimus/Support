<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use Faker\Factory;
use Illuminate\Support\Collection;

/**
 * Class ModelFactoryBuilder
 */
class ModelFactoryBuilder
{
    /**
     * The class
     * @var string|Model
     */
    private $class;

    /**
     * How many to make
     * @var int
     */
    private $count;

    /**
     * The callable definition
     * @var callable
     */
    private $definition;

    /**
     * ModelFactoryBuilder constructor.
     *
     * @param callable     $definition The definition
     * @param string|Model $class      The class to create
     * @param int|null     $count      How many to create
     */
    public function __construct(callable $definition, string $class, ?int $count)
    {
        $this->class = $class;
        $this->count = $count ?: 1;
        $this->definition = $definition;
    }

    /**
     * @param string[]|array $params The params
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

    /**
     * @param string[]|array $params The params
     *
     * @return \Illuminate\Database\Eloquent\Model[]|Model
     */
    public function make(array $params = [])
    {
        $class = $this->class;
        $definition = $this->definition;
        $results = [];
        for ($i = 0; $i < $this->count; $i++) {
            $results[] = new $class(array_merge($definition(Factory::create()), $params));
        }

        if ($this->count === 1) {
            return $results[0];
        }

        return $results;
    }
}
