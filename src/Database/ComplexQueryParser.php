<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use InvalidArgumentException;

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
     * @return bool
     */
    public function isComplexQuery($value): bool
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
     * @return Builder|Relation
     */
    public function query($query, string $property, string $value)
    {
        $this->typecheck($query, 'complex');
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
     * @return Builder|Relation
     */
    protected function gt($query, string $property, string $statement)
    {
        if ($statement === 'now') {
            $statement = new DateTime;
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
     * @return Builder|Relation
     */
    protected function in($query, string $property, string $statement)
    {
        $hasNull = false;
        $possibilities = array_map(function ($value) use (&$hasNull) {
            if ($value === 'null') {
                $value = null;
                $hasNull = true;
            }

            return $value;
        }, explode(',', $statement));

        if (!$hasNull) {
            return $query->whereIn($property, $possibilities);
        }

        return $query->where(function (Builder $sub) use ($property, $possibilities) {
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
     * @return Builder|Relation
     */
    protected function like($query, string $property, string $statement)
    {
        $query->where($property, 'LIKE', $statement);
        return $query;
    }

    /**
     * Build a complex query based off of a 'gt' query
     *
     * @param Builder|Relation $query     The query to add on to
     * @param string           $property  The property being manipulated
     * @param string           $statement The complex query string
     *
     * @return Builder|Relation
     */
    protected function lt($query, string $property, string $statement)
    {
        if ($statement === 'now') {
            $statement = new DateTime;
        }

        return $query->where($property, '<', $statement);
    }

    /**
     * Check if the parameter was a valid type
     *
     * @param mixed  $object The object to inspect
     * @param string $method The method that is calling this bad boy
     *
     * @throws InvalidArgumentException if the object was not appropriate
     * @return void
     */
    private function typecheck($object, string $method): void
    {
        if (!$object instanceof Builder && !$object instanceof Relation) {
            throw new InvalidArgumentException(
                'Argument 1 passed to '.get_class($this).'::'.$method.'() must be '.
                'in instance of '.Builder::class.' or '.Relation::class.', '.
                'instance of '.get_class($object).' given'
            );
        }
    }
}
