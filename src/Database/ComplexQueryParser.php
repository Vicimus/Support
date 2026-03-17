<?php

declare(strict_types=1);

namespace Vicimus\Support\Database;

use DateTime;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;

class ComplexQueryParser
{
    /**
     * Check if a parameter value is considered a complex query or not
     */
    public function isComplexQuery(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $complex = [
            'in:',
            'like:',
            'gt:',
            'lt:',
            'or:',
        ];

        foreach ($complex as $pattern) {
            if (str_starts_with($value, $pattern)) {
                return true;
            }
        }

        return false;
    }

    public function query(
        EloquentBuilder | Builder | Relation $query,
        string $property,
        string $value,
    ): Builder | Relation | EloquentBuilder {
        [$type, $statement] = explode(':', $value);

        return $this->$type($query, $property, $statement);
    }

    protected function gt(
        EloquentBuilder | Builder | Relation $query,
        string $property,
        string $statement,
    ): EloquentBuilder | Builder | Relation {
        if ($statement === 'now') {
            $statement = new DateTime();
        }

        return $query->where($property, '>', $statement);
    }

    protected function in(
        EloquentBuilder | Builder | Relation $query,
        string $property,
        string $statement,
    ): EloquentBuilder | Builder | Relation {
        $hasNull = false;
        $possibilities = array_map(static function ($value) use (&$hasNull) {
            if ($value === 'null') {
                $value = null;
                $hasNull = true;
            }

            return $value;
        }, explode(',', $statement));

        if (!$hasNull) {
            return $query->whereIn($property, $possibilities);
        }

        return $query->where(static function (Builder $sub) use ($property, $possibilities): void {
            $sub->whereIn($property, $possibilities)
                ->orWhereNull($property);
        });
    }

    protected function like(
        EloquentBuilder | Builder | Relation $query,
        string $property,
        string $statement,
    ): EloquentBuilder | Builder | Relation {
        $query->where($property, 'LIKE', $statement);
        return $query;
    }

    protected function lt(
        EloquentBuilder | Builder | Relation $query,
        string $property,
        string $statement
    ): EloquentBuilder | Builder | Relation {
        if ($statement === 'now') {
            $statement = new DateTime();
        }

        return $query->where($property, '<', $statement);
    }
}
