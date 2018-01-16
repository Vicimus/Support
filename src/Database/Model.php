<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use Illuminate\Database\Eloquent\Model as LaravelModel;

/**
 * Base class we can use in most of our projects
 *
 * @method static \Illuminate\Database\Eloquent\Builder orderBy($column, $ascending = true)
 * @method static \Illuminate\Database\Eloquent\Model|static find($id)
 * @method static \Illuminate\Database\Eloquent\Model|static findOrFail($id)
 * @method static \Illuminate\Database\Eloquent\Builder|static where($c, $v = null, $v = null, $b = 'and')
 * @method static \Illuminate\Database\Eloquent\Model|static create($attributes)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereHas($relation, $closure)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereIn($column, $items)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNotIn($column, $items)
 * @method static \Illuminate\Database\Eloquent\Builder|static withTrashed()
 * @method static \Illuminate\Database\Eloquent\Model|static firstOrCreate($attributes)
 * @method static \Illuminate\database\Eloquent\Model|static firstOrFail()
 * @method static \Illuminate\Database\Eloquent\Model|static first()
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
}
