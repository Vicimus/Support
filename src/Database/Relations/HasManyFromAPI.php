<?php declare(strict_types = 1);

namespace Vicimus\Support\Database\Relations;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use InvalidArgumentException;

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
     * HasManyFromAPI constructor.
     *
     * @param DatabaseManager $db       Laravel based Database Manager
     * @param int             $id       The ID of the model this is on
     * @param string          $table    The table of the model
     * @param string          $relation The relation to build
     */
    public function __construct(DatabaseManager $db, int $id, string $table, string $relation)
    {
        $this->db = $db;
        $this->id = $id;

        $elements = [$this->singular($table), $this->singular($relation)];
        sort($elements);

        $this->left = $this->singular($table) . '_id';
        $this->right = $this->singular($relation) . '_id';

        $this->table = implode('_', $elements);
        $this->collection = new Collection;
    }

    /**
     * Associate a local model with a remote model
     *
     * @param int[] $ids The IDs to associate
     *
     * @return void
     */
    public function associate(array $ids): void
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
     * Get the internal query
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->populate();
    }

    /**
     * Get the relationship collection
     *
     * @return Collection
     */
    protected function populate(): Collection
    {
         $this->collection = $this->db->table($this->table)->where($this->left, $this->id)->get();
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
