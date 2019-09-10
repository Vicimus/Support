<?php

namespace Vicimus\Support\Database;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as LaravelModel;

/**
 * Base class we can use in most of our projects
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static orderBy($column, $ascending = true)
 * @method static LaravelModel|static find($id)
 * @method static LaravelModel|static findOrFail($id)
 * @method static \Illuminate\Database\Eloquent\Builder|static where($c, $v = null, $v = null, $b = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static distinct($column = null))
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNotNull($c)
 * @method static LaravelModel|static create($attributes)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNull($c)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereHas($relation, $closure)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereIn($column, $items)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNotIn($column, $items)
 * @method static \Illuminate\Database\Eloquent\Builder|static withTrashed()
 * @method static LaravelModel|static firstOrCreate($attributes)
 * @method static \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|static query()
 * @method static LaravelModel|static firstOrFail()
 * @method static LaravelModel|static first()
 * @method static \Illuminate\Database\Eloquent\Builder|static select($fields)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereDoesntHave($relation, $closure = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static take(int $number)
 * @method static \Illuminate\Database\Eloquent\Builder|static has(string $relationship)
 * @method static bool truncate()
 * @method static int count()
 *
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Model extends LaravelModel
{
    /**
     * Should we cast or not
     *
     * @var bool
     */
    private static $noCasts = [];

    /**
     * Store the columns
     * @var string[]
     */
    private $columns = [];

    /**
     * Properties protected from mass assignment
     *
     * @var string[]
     */
    protected $guarded = [
        'id', 'updated_at', 'created_at',
    ];

    /**
     * Get an attribute from the model.
     *
     * @param string|mixed $key The key to get
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (!isset(self::$noCasts[static::class])) {
            return parent::getAttribute($key);
        }

        if (!$key) {
            return null;
        }

        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        // Here we will determine if the model base class itself contains this given key
        // since we don't want to treat any of those methods as relationships because
        // they are all intended as helper methods and none of these are relations.
        if (method_exists(self::class, $key)) {
            return null;
        }

        return $this->getRelationValue($key);
    }

    /**
     * Get the "deleted at" column for the builder.
     *
     * @return string
     */
    protected function getDeletedAtColumn()
    {
        return 'deleted_at';
    }

    /**
     * Get a list of the columns
     *
     * @return string[]
     */
    public function getTableColumns()
    {
        if (count($this->columns)) {
            return $this->columns;
        }

        $this->columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->table);
        return $this->columns;
    }

    /**
     * Check if table column exists
     *
     * @param string $column The column
     *
     * @return bool
     */
    public function hasColumn($column)
    {
        return in_array($column, $this->getTableColumns(), false);
    }

    /**
     * Get a relative
     *
     * Mainly used for mocks
     *
     * @param string $relative The relative to get
     *
     * @return mixed
     */
    public function relation($relative)
    {
        return $this->$relative;
    }

    /**
     * Reset all
     *
     * @return void
     */
    public static function resetAll()
    {
        self::$noCasts = [];
    }

    /**
     * Turn off casting
     *
     * @return void
     */
    public static function withoutCasts()
    {
        self::$noCasts[static::class] = true;
    }
}
