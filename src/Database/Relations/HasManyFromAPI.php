<?php declare(strict_types = 1);

namespace Vicimus\Support\Database\Relations;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use stdClass;
use Vicimus\Support\Classes\DateTime;
use Vicimus\Support\Database\ApiModel;
use Vicimus\Support\Exceptions\ApiRelationException;

/**
 * Class HasManyFromAPI
 */
class HasManyFromAPI
{
    /** Available casts */
    private const CASTS = ['int', 'bool', 'array'];

    /**
     * Insert threshold
     */
    private const THRESHOLD = 1000;

    /**
     * Cast columns
     *
     * @var string[]
     */
    protected $casts = [];

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
     * @param DatabaseManager $dbase    Laravel based Database Manager
     * @param int             $id       The ID of the model this is on
     * @param string          $table    The table of the model
     * @param string          $relation The relation to build
     * @param callable|null   $loader   Callable function to call on the query
     */
    public function __construct(
        DatabaseManager $dbase,
        int $id,
        string $table,
        string $relation,
        ?callable $loader = null
    ) {
        $this->db = $dbase;
        $this->id = $id;

        $elements = [$this->singular($table), $this->singular($relation)];
        sort($elements);

        $this->left = $this->singular($table) . '_id';
        $this->right = $this->singular($relation) . '_id';

        $this->table = implode('_', $elements);
        $this->collection = new Collection();
        $this->loader = $loader;
    }

    /**
     * Associate a local model with a remote model
     *
     * @param int[]   $ids        The IDs to associate
     * @param mixed[] $additional Additional columns to insert
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public function associate(array $ids, array $additional = []): void
    {
        $records = [];
        foreach (array_unique($ids) as $id) {
            if (!is_int($id)) {
                throw new InvalidArgumentException(
                    'Associate requires an array of integers'
                );
            }

            $records[] = $this->buildInsertion($id, $additional[$id] ?? []);
            if (count($records) < self::THRESHOLD) {
                continue;
            }

            $this->execute($records);
            $records = [];
        }

        $this->execute($records);
    }

    /**
     * Casts properties of the model
     *
     * @param string[] $casts Cast certain columns of the join
     *
     * @return HasManyFromAPI
     */
    public function casts(array $casts): self
    {
        $this->casts = $casts;
        return $this;
    }

    /**
     * Clear the relationship
     * @param int $leftSide The left side id
     *
     * @return void
     */
    public function clear(int $leftSide): void
    {
        $this->db->table($this->table)
            ->where($this->left, $leftSide)
            ->delete();
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
     * @return ApiModel
     */
    public function find(int $id): ApiModel
    {
        return new ApiModel($this, $this->query()
            ->where($this->left, $this->id)
            ->where($this->right, $id)
            ->first());
    }

    /**
     * Find a join record
     *
     * @param int $id The ID of the remote model
     *
     * @throws ModelNotFoundException
     * @return ApiModel
     */
    public function findOrFail(int $id): ApiModel
    {
        $result = $this->query()
            ->where($this->left, $this->id)
            ->where($this->right, $id)
            ->first();

        if (!$result) {
            throw new ModelNotFoundException(sprintf(
                'No match found for join between %s #%s -> %s #%s',
                $this->left,
                $this->id,
                $this->right,
                $id
            ));
        }

        return new ApiModel($this, $result);
    }

    /**
     * Get the internal query
     *
     * @throws ApiRelationException
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
     * @throws ApiRelationException
     *
     * @return mixed
     */
    public function load()
    {
        $method = $this->loader;

        if (!$method) {
            throw new ApiRelationException('No loader provided', 500);
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
     * Update a join row with some new data
     *
     * @param int     $id     The id of the join
     * @param mixed[] $params Params to update
     *
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->update($params);

        return true;
    }

    /**
     * Update a row based on a search
     *
     * @param string   $column     The column to search through
     * @param mixed    $identifier The value to search for
     * @param string[] $params     The parameters to use with the update
     *
     * @return bool
     */
    public function updateByColumn(string $column, $identifier, array $params): bool
    {
        return $this->db->table($this->table)
            ->where($column, $identifier)
            ->update($params) !== 0;
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
     * Apply any casts defined
     *
     * @param string $property The property
     * @param mixed  $value    The value to assign
     *
     * @throws ApiRelationException
     *
     * @return mixed
     */
    protected function applyCasts(string $property, $value)
    {
        if (!array_key_exists($property, $this->casts)) {
            return $value;
        }

        $cast = $this->casts[$property];
        if (!in_array($cast, self::CASTS, true)) {
            throw new ApiRelationException('Invalid cast term ' . $cast);
        }

        return $this->doCast($cast, $value);
    }

    /**
     * Convert a row into an instance of the related class, unless not specified
     * then it'll be an stdClass
     *
     * @param mixed $row The row to convert
     *
     * @throws ApiRelationException
     *
     * @return mixed
     */
    protected function instance($row)
    {
        $identifier = $this->right;
        $instance = new stdClass();
        if (isset($row->$identifier)) {
            $instance->id = $row->$identifier;
        }

        if (!is_array($row) && !is_object($row)) {
            throw new ApiRelationException(sprintf('Expected array or object, received %s', var_export($row, true)));
        }

        foreach ($row as $property => $value) {
            $instance->$property = $this->applyCasts($property, $value);
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
        if ($table[strlen($table) - 1] === 's') {
            return substr($table, 0, -1);
        }

        return $table;
    }

    /**
     * Build the array that will be inserted into the array
     *
     * @param int     $id         The id being inserted
     * @param mixed[] $additional Any additional parameters
     *
     * @return mixed[]
     */
    private function buildInsertion(int $id, array $additional): array
    {
        $insertion = [];
        $insertion[$this->left] = $this->id;
        $insertion[$this->right] = $id;

        return array_merge($insertion, $additional, [
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }

    /**
     * Do the cast
     *
     * @param string $cast  The cast
     * @param mixed  $value The value
     *
     * @return bool|int|mixed
     */
    private function doCast(string $cast, $value)
    {
        switch ($cast) {
            case 'bool':
                return (bool) $value;
            case 'int':
                return (int) $value;
            case 'array':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Execute the insertion
     *
     * @param mixed[] $records The records to insert
     *
     * @return void
     */
    private function execute(array $records): void
    {
        if (!count($records)) {
            return;
        }

        $this->db->table($this->table)
            ->insert($records);
    }
}
