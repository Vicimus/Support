<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use Illuminate\Database\DatabaseManager;
use Vicimus\Support\Database\Relations\HasManyFromAPI;
use Vicimus\Support\Exceptions\ApiRelationException;

/**
 * Trait APIAssociates
 *
 * @package Vicimus\Support\Database
 */
trait APIAssociates
{
    /**
     * Get the results of an association
     *
     * @param DatabaseManager $db       Inject the Database Manager `app('db')`
     * @param string          $relation The relationship to establish
     * @param callable|null   $loader   Optional callable to use on the retrieved collection
     *
     * @throws ApiRelationException
     *
     * @return HasManyFromAPI
     */
    public function hasManyFromAPI(DatabaseManager $db, string $relation, ?callable $loader = null): HasManyFromAPI
    {
        if (!$this->id) {
            throw new ApiRelationException(
                'Local model must have an id (must be saved) before attempting to collect it\'s relations'
            );
        }

        return new HasManyFromAPI($db, $this->id, $this->table, $relation, $loader);
    }
}
