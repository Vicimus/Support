<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use Illuminate\Database\Eloquent\Model as LaravelModel;

/**
 * Base class we can use in most of our projects
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
