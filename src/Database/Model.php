<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use Throwable;

/**
 * Base class we can use in most of our projects
 *
 * @method static Builder orderBy($column, $ascending = true)
 * @method static static find($id)
 * @method static static findOrFail($id)
 * @method static Builder|static where($c, $v = null, $v = null, $b = 'and')
 * @method static Builder|static whereNotNull($c)
 * @method static LaravelModel|static create($attributes = [])
 * @method static Builder|static whereNull($c)
 * @method static Builder|static whereHas($relation, $closure)
 * @method static Builder|static whereIn($column, $items)
 * @method static Builder|static whereNotIn($column, $items)
 * @method static Builder|static orWhereNotIn($column, $items)
 * @method static Builder|static withTrashed()
 * @method static LaravelModel|static firstOrCreate($attributes)
 * @method static Builder|static query()
 * @method static LaravelModel|static firstOrFail()
 * @method static LaravelModel|static first()
 * @method static Builder|static select($fields)
 * @method static Builder|static whereDoesntHave($relation, $closure = null)
 * @method static Builder|static take(int $number)
 * @method static Builder|static has(string $relationship)
 * @method static bool truncate()
 * @method static int count()
 */
class Model extends LaravelModel
{
    /**
     * Properties protected from mass assignment
     *
     * @var string[]
     */
    protected $guarded = [
        'id', 'updated_at', 'created_at',
    ];

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
     * Override the delete method so it stops making us try catch it
     *
     * phpcs:disable
     *
     * @noinspection PhpDocMissingThrowsInspection
     * @param bool $throw Optionally throw on error or ignore
     *
     * @return bool|null
     */
    public function delete(bool $throw = false): ?bool
    {
        // phpcs:enable
        try {
            $result = parent::delete();
        } catch (Throwable $exception) {
            if ($throw) {
                /** @noinspection PhpUnhandledExceptionInspection */
                throw $exception;
            }

            return false;
        }

        return $result;
    }

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
    public function hasColumn(string $column): bool
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
     * Prepare a date for array / JSON serialization.
     *
     * @param DateTimeInterface $date The date
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
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
