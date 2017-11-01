<?php declare(strict_types = 1);

namespace Vicimus\Support\Database\Relations;

use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use stdClass;

/**
 * Class HasManyFromAPI
 *
 * @package Vicimus\Support\Database\Relations
 */
class HasManyFromAPI
{
    /**
     * The collection of associations
     *
     * @var Collection
     */
    protected $collection;

    /**
     * Laravel database manager
     *
     * @var DatabaseManager
     */
    protected $db;

    /**
     * This is the class consuming this instance
     *
     * @var string
     */
    protected $id;

    /**
     * The left side foreign key
     *
     * @var string
     */
    protected $left;

    /**
     * Callable loader to use with the query
     *
     * @var
     */
    protected $loader;

    /**
     * The right side foreign key
     *
     * @var string
     */
    protected $right;

    /**
     * This is the join table that will be used
     *
     * @var string
     */
    protected $table;

    /**
     * Additional columns on the table
     *
     * @var string[]
     */
    protected $with = [];

    /**
     * HasManyFromAPI constructor.
     *
     * @param DatabaseManager $db       Laravel based Database Manager
     * @param int             $id       The ID of the model this is on
     * @param string          $table    The table of the model
     * @param string          $relation The relation to build
     * @param callable|null   $loader   Callable function to call on the query
     */
    public function __construct(DatabaseManager $db, int $id, string $table, string $relation, ?callable $loader = null)
    {
        $this->db = $db;
        $this->id = $id;

        $elements = [$this->singular($table), $this->singular($relation)];
        sort($elements);

        $this->left = $this->singular($table) . '_id';
        $this->right = $this->singular($relation) . '_id';

        $this->table = implode('_', $elements);
        $this->collection = new Collection;
        $this->loader = $loader;
    }

    /**
     * Associate a local model with a remote model
     *
     * @param int[]   $ids        The IDs to associate
     * @param mixed[] $additional Additional columns to insert
     *
     * @return void
     */
    public function associate(array $ids, array $additional = []): void
    {
        foreach (array_unique($ids) as $id) {
            if (!is_int($id)) {
                throw new InvalidArgumentException(
                    'Associate requires an array of integers'
                );
            }

            $insertion = [];
            $insertion[$this->left] = $this->id;
            $insertion[$this->right] = $id;

            $add = $additional[$id] ?? [];
            $insertion = array_merge($insertion, $add);

            $this->db->table($this->table)
                ->insert($insertion);
        }
    }

    /**
     * Count the number of items in the relationship
     *
     * @return int
     */
    public function count(): int
    {
        $this->populate();
        return $this->collection->count();
    }

    /**
     * Remote associations
     *
     * @param int[] $ids The IDs to remove
     *
     * @return void
     */
    public function dissociate(array $ids): void
    {
        if (!count($ids)) {
            return;
        }

        $this->db->table($this->table)
            ->whereIn($this->right, $ids)
            ->delete();
    }

    /**
     * Find a join record
     *
     * @param int $id The ID of the remote model
     *
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->query()->where($this->right, $id)->first();
    }

    /**
     * Get the internal query
     *
     * @return Collection
     */
    public function get(): Collection
    {
        $payload = [];

        $query = $this->populate();
        foreach ($query as $row) {
            $payload[] = $this->instance($row);
        }

        return new Collection($payload);
    }

    /**
     * Call the loader method on the collection
     *
     * @return mixed
     */
    public function load()
    {
        $method = $this->loader;

        if (!$method) {
            throw new Exception('No loader provided', 422);
        }

        return $method($this->get());
    }


    /**
     * Get the query
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->db->table($this->table)->select('*')->where($this->left, $this->id);
    }

    /**
     * Get the raw join collection
     *
     * @return Collection
     */
    public function raw(): Collection
    {
        return $this->populate();
    }

    /**
     * Defines other columns on the join table
     *
     * @param string[] $columns Additional columns
     *
     * @return HasManyFromAPI
     */
    public function with(array $columns): HasManyFromAPI
    {
        $this->with = array_merge($this->with, $columns);
        return $this;
    }

    /**
     * Convert a row into an instance of the related class, unless not specified
     * then it'll be an stdClass
     *
     * @param mixed $row The row to convert
     *
     * @return mixed
     */
    protected function instance($row)
    {
        $identifier = $this->right;
        $instance = new stdClass;
        if (isset($row->$identifier)) {
            $instance->id = $row->$identifier;
        }

        foreach ($row as $property => $value) {
            $instance->$property = $value;
        }

        return $instance;
    }

    /**
     * Get the relationship collection
     *
     * @return Collection
     */
    protected function populate(): Collection
    {
         $this->collection = $this->query()->get();
         return $this->collection;
    }

    /**
     * Get the singular form of a string
     *
     * @param string $table The table name
     *
     * @return string
     */
    protected function singular(string $table): string
    {
        if (substr($table, -1, 1) === 's') {
            return substr($table, 0, -1);
        }

        return $table;
    }
}
