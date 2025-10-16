<?php

declare(strict_types=1);

namespace Vicimus\Support\Database;

use Carbon\CarbonImmutable;
use DateTimeImmutable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Support\Carbon;
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
 * @method static static updateOrCreate(array $check, array $attributes)
 * @method static static firstOrNew(array $unique)
 * @property int $id
 */
class Model extends LaravelModel
{
    public static bool $throwDeleteErrors = true;

    /**
     * Properties protected from mass assignment
     *
     * @var string[]
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected $guarded = [
        'id', 'updated_at', 'created_at',
    ];

    /**
     * Should we cast or not
     * @var bool[]
     */
    private static array $noCasts = [];

    /**
     * Store the columns
     * @var string[]
     */
    private array $columns = [];

    /**
     * Respect no casts rule
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     *
     * @return mixed[]
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
     * @throws Throwable
     */
    public function delete(?bool $throw = null): ?bool
    {
        $throw ??= self::$throwDeleteErrors;

        // phpcs:enable
        try {
            $result = parent::delete();
        } catch (Throwable $exception) {
            if ($throw) {
                throw $exception;
            }

            return false;
        }

        return $result;
    }

    /**
     * Get an attribute from the model.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
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
     */
    public function hasColumn(string $column): bool
    {
        return in_array($column, $this->getTableColumns(), true);
    }

    /**
     * Get a relative
     *
     * Mainly used for mocks
     */
    public function relation(string $relative): mixed
    {
        return $this->$relative;
    }

    public static function resetAll(): void
    {
        self::$noCasts = [];
    }

    /**
     * Override set attribute
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     *
     * @param string|mixed $key   The key to set
     * @param mixed        $value The value to set it to
     *
     * @return mixed
     *
     * phpcs:disable
     *
     */
    public function setAttribute($key, $value)
    {
        if (!(self::$noCasts[static::class] ?? false)) {
            return parent::setAttribute($key, $value);
        }

        $this->attributes[$key] = $value;
    }

    public static function withoutCasts(): void
    {
        self::$noCasts[static::class] = true;
    }

    /**
     * Serialize dates to how they should be formatted for JSON.
     */
    protected function serializeDate(DateTimeInterface $date): ?string
    {
        if ($date instanceof DateTimeImmutable) {
            return CarbonImmutable::instance($date)->toISOString(true);
        }

        return Carbon::instance($date)->toISOString(true);
    }
}
