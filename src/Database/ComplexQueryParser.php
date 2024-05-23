<?php

declare(strict_types=1);

namespace Vicimus\Support\Database;

use DateTime;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Vicimus\Support\Exceptions\InvalidArgumentException;

/**
 * Handles the more complex queries for the API
 */
class ComplexQueryParser
{
    /**
     * Check if a parameter value is considered a complex query or not
     *
     * @param mixed $value The value of the query property
     *
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
            if (substr($value, 0, strlen($pattern)) === $pattern) {
                return true;
            }
        }

        return false;
    }

    /**
     * Build a complex query based off of a submitted value
     *
     * @param Builder|Relation $query    The query to add on to
     * @param string           $property The property being manipulated
     * @param string           $value    The complex query string
     *
     */
    public function query(Builder|Relation $query, string $property, string $value): Builder|Relation
    {
        $this->typeCheck($query);
        list($type, $statement) = explode(':', $value);

        return $this->$type($query, $property, $statement);
    }

    /**
     * Build a complex query based off of a 'gt' query
     *
     * @param Builder|Relation $query     The query to add on to
     * @param string           $property  The property being manipulated
     * @param string           $statement The complex query string
     *
     */
    protected function gt(Builder|Relation $query, string $property, string $statement): Builder|Relation
    {
        if ($statement === 'now') {
            $statement = new DateTime();
        }

        return $query->where($property, '>', $statement);
    }

    /**
     * Build a complex query based off of a 'in' query
     *
     * @param Builder|Relation $query     The query to add on to
     * @param string           $property  The property being manipulated
     * @param string           $statement The complex query string
     *
     */
    protected function in(Builder|Relation $query, string $property, string $statement): Builder|Relation
    {
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

    /**
     * Build a complex query based off of a 'like' query
     *
     * @param Builder|Relation $query     The query to add on to
     * @param string           $property  The property being manipulated
     * @param string           $statement The complex query string
     *
     */
    protected function like(Builder|Relation $query, string $property, string $statement): Builder|Relation
    {
        $query->where($property, 'LIKE', $statement);
        return $query;
    }

    /**
     * Build a complex query based off of a 'lt' query
     *
     * @param Builder|Relation $query     The query to add on to
     * @param string           $property  The property being manipulated
     * @param string           $statement The complex query string
     *
     */
    protected function lt(Builder|Relation $query, string $property, string $statement): Builder|Relation
    {
        if ($statement === 'now') {
            $statement = new DateTime();
        }

        return $query->where($property, '<', $statement);
    }

    /**
     * Check if the parameter was a valid type
     *
     * @param mixed $object The object to inspect
     *
     * @throws InvalidArgumentException if the object was not appropriate
     */
    private function typeCheck(mixed $object): void
    {
        if (!$object instanceof Builder && !$object instanceof Relation && !$object instanceof EloquentBuilder) {
            throw new InvalidArgumentException($object, EloquentBuilder::class, Builder::class, Relation::class);
        }
    }
}
