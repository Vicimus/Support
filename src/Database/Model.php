<?php

declare(strict_types=1);

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
    protected array $guarded = [
        'id', 'updated_at', 'created_at',
    ];

    /**
     * Should we cast or not
     *
     */
    private static bool $noCasts = [];

    /**
     * Store the columns
     * @var string[]
     */
    private array $columns = [];

    /**
     * Respect no casts rule
     *
     */
    public function attributesToArray(): mixed
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
     */
    public function getAttribute(mixed $key): mixed
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
     */
    public function relation(string $relative): mixed
    {
        return $this->$relative;
    }

    /**
     * Reset all
     *
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
     */
    public function setAttribute(mixed $key, mixed $value): mixed
    {
        if (!(self::$noCasts[static::class] ?? false)) {
            return parent::setAttribute($key, $value);
        }

        $this->attributes[$key] = $value;
    }

    /**
     * Turn off casting
     *
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
     */
    protected function removeTableFromKey(string|int $key): string
    {
        return Str::contains($key, '.') ? last(explode('.', $key)) : $key;
    }

    /**
     * Serialize dates to how they should be formatted for JSON.
     *
     * @param DateTimeInterface $date The date object
     *
     */
    protected function serializeDate(DateTimeInterface $date): ?string
    {
        if ($date instanceof DateTimeImmutable) {
            return CarbonImmutable::instance($date)->toISOString(true);
        }

        return Carbon::instance($date)->toISOString(true);
    }
}
