<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use Illuminate\Database\Eloquent\Model as LaravelModel;

/**
 * Base class we can use in most of our projects
 *
 * @method static \Illuminate\Database\Eloquent\Builder where($column, $value = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Model create($attributes)
 * @method static \Illuminate\Database\Eloquent\Builder orderBy($column, $ascending)
 * @method static \Illuminate\Database\Eloquent\Model find($id)
 * @method static \Illuminate\Database\Eloquent\Builder whereHas($relation, $closure)
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
