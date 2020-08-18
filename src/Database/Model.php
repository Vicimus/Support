<?php

namespace Vicimus\Support\Database;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use Vicimus\Eevee\Models\Joins\PageBlock;
use Vicimus\Support\Traits\CastsAttributes;

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
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhereNotIn($column, $items)
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
 * @method static \Illuminate\Database\Eloquent\Builder|static groupBy(string $column)
 *
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Model extends LaravelModel
{
    use CastsAttributes;

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
     * Casts
     * @var string[]
     */
    protected $casts = [];

    /**
     * Properties protected from mass assignment
     *
     * @var string[]
     */
    protected $guarded = [
        'id', 'updated_at', 'created_at',
    ];

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = $this->getArrayableAttributes();

        // If an attribute is a date, we will cast it to a string after converting it
        // to a DateTime / Carbon instance. This is so we will get some consistent
        // formatting while accessing attributes vs. arraying / JSONing a model.
        foreach ($this->getDates() as $key)
        {
            if ( ! isset($attributes[$key])) continue;

            $attributes[$key] = (string) $this->asDateTime($attributes[$key]);
        }

        // We want to spin through all the mutated attributes for this model and call
        // the mutator for the attribute. We cache off every mutated attributes so
        // we don't have to constantly check on attributes that actually change.
        foreach ($this->getMutatedAttributes() as $key)
        {
            if ( ! array_key_exists($key, $attributes)) continue;

            $attributes[$key] = $this->mutateAttributeForArray(
                $key, $attributes[$key]
            );
        }

        // Here we will grab all of the appended, calculated attributes to this model
        // as these attributes are not really in the attributes array, but are run
        // when we need to array or JSON the model for convenience to the coder.
        foreach ($this->getArrayableAppends() as $key)
        {
            $attributes[$key] = $this->mutateAttributeForArray($key, null);
        }

        $castAttributes = [];
        foreach ($attributes as $key => $value) {
            $castAttributes[$key] = $this->doAttributeCast($key, $value);
        }

        return $castAttributes;
    }

    /**
     * Get an attribute from the model.
     *
     * @param string|mixed $key The key to get
     *
     * @return mixed
     */
    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $inAttributes = array_key_exists($key, $this->attributes);

        // If the key references an attribute, we can just go ahead and return the
        // plain attribute value from the model. This allows every attribute to
        // be dynamically accessed through the _get method without accessors.
        if ($inAttributes || $this->hasGetMutator($key))
        {
            return $this->doAttributeCast($key, $this->getAttributeValue($key));
        }

        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if (array_key_exists($key, $this->relations))
        {
            return $this->relations[$key];
        }

        // If the "attribute" exists as a method on the model, we will just assume
        // it is a relationship and will load and return results from the query
        // and hydrate the relationship's value on the "relationships" array.
        $camelKey = camel_case($key);

        if (method_exists($this, $camelKey))
        {
            return $this->getRelationshipFromMethod($key, $camelKey);
        }
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
