<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use Carbon\CarbonImmutable;
use DateTimeImmutable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Throwable;

/**
 * Base class we can use in most of our projects
 *
 * @method static Builder orderBy($column, $ascending = true)
 * @method static static|null find($id)
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
 * @method static LaravelModel|static firstOrCreate(...$attributes)
 * @method static Builder|static query()
 * @method static LaravelModel|static firstOrFail()
 * @method static LaravelModel|static first()
 * @method static Builder|static select($fields)
 * @method static Builder|static whereDoesntHave($relation, $closure = null)
 * @method static Builder|static take(int $number)
 * @method static Builder|static has(string $relationship)
 * @method static bool truncate()
 * @method static int count()
 * @property int $id
 */
class Model extends LaravelModel
{
    public static $throwDeleteErrors = true;

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
     * Respect no casts rule
     *
     * @return mixed
     */
    public function attributesToArray()
    {
        if (!(self::$noCasts[static::class] ?? false)) {
            return parent::attributesToArray();
        }

        return $this->attributes;
    }

    /**
     * Override the delete method so it stops making us try catch it
     *
     * phpcs:disable
     *
     * @noinspection PhpDocMissingThrowsInspection
     * @param bool|null $throw Optionally throw on error or ignore
     *
     * @return bool|null
     */
    public function delete(?bool $throw = null): ?bool
    {
        $throw ??= self::$throwDeleteErrors;

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
     * Override set attribute
     *
     * @param string|mixed $key   The key to set
     * @param mixed        $value The value to set it to
     *
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if (!(self::$noCasts[static::class] ?? false)) {
            return parent::setAttribute($key, $value);
        }

        $this->attributes[$key] = $value;
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

    /**
     * Remove the table name from a given key.
     *
     * Overrides Laravels version which broke between 7.20 and 7.25
     *
     * @param string|int $key The key to check
     * @return string
     */
    protected function removeTableFromKey($key)
    {
        return Str::contains($key, '.') ? last(explode('.', $key)) : $key;
    }

    /**
     * Serialize dates to how they should be formatted for JSON.
     *
     * @param DateTimeInterface $date The date object
     *
     * @return string|null
     */
    protected function serializeDate(DateTimeInterface $date): ?string
    {
        if ($date instanceof DateTimeImmutable) {
            return CarbonImmutable::instance($date)->toISOString(true);
        }

        return Carbon::instance($date)->toISOString(true);
    }
}
