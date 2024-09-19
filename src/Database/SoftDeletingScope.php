<?php

declare(strict_types=1);

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
     * phpcs:disable
     */
    public function extend(Builder $builder): void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }

        $builder->onDelete(static function (Builder $builder) {
            return $builder->update([
                'deleted_at' => $builder->getModel()->freshTimestampString(),
            ]);
        });
    }
}
