<?php

namespace Vicimus\Support\Database;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope as LaravelScope;

/**
 * Class SoftDeletingScope
 */
class SoftDeletingScope extends LaravelScope
{
    /**
     * Extend the query builder with the needed functions.
     *
     * @param Builder $builder The builder instance
     *
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension)
        {
            $this->{"add{$extension}"}($builder);
        }

        $builder->onDelete(function(Builder $builder)
        {
            return $builder->update(array(
                'deleted_at' => $builder->getModel()->freshTimestampString()
            ));
        });
    }
}
