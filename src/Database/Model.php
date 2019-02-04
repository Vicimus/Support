<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use Illuminate\Database\Eloquent\Model as LaravelModel;

/**
 * Base class we can use in most of our projects
 *
 * @method static \Illuminate\Database\Eloquent\Builder orderBy($column, $ascending = true)
 * @method static LaravelModel|static find($id)
 * @method static LaravelModel|static findOrFail($id)
 * @method static \Illuminate\Database\Eloquent\Builder|static where($c, $v = null, $v = null, $b = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNotNull($c)
 * @method static LaravelModel|static create($attributes = [])
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNull($c)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereHas($relation, $closure)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereIn($column, $items)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNotIn($column, $items)
 * @method static \Illuminate\Database\Eloquent\Builder|static withTrashed()
 * @method static LaravelModel|static firstOrCreate($attributes)
 * @method static \Illuminate\Database\Eloquent\Builder|static query()
 * @method static LaravelModel|static firstOrFail()
 * @method static LaravelModel|static first()
 * @method static \Illuminate\Database\Eloquent\Builder|static select($fields)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereDoesntHave($relation, $closure = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static take(int $number)
 * @method static \Illuminate\Database\Eloquent\Builder|static has(string $relationship)
 * @method static bool truncate()
 * @method static int count()
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
        if (!(self::$noCasts[static::class] ?? false)) {
            return parent::getAttribute($key);
        }

        if (!$key) {
            return null;
        }

        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key] ?? null;
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
     * Get a list of the columns
     *
     * @return string[]
     */
    public function getTableColumns(): array
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->table);
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
    public function relation(string $relative)
    {
        return $this->$relative;
    }

    /**
     * Reset all
     *
     * @return void
     */
    public static function resetAll(): void
    {
        self::$noCasts = [];
    }

    /**
     * Turn off casting
     *
     * @return void
     */
    public static function withoutCasts(): void
    {
        self::$noCasts[static::class] = true;
    }
}
