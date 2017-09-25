<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use Illuminate\Database\DatabaseManager;
use Vicimus\Support\Database\Relations\HasManyFromAPI;

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
     *
     * @return HasManyFromAPI
     */
    public function hasManyFromAPI(DatabaseManager $db, string $relation): HasManyFromAPI
    {
        return new HasManyFromAPI($db, $this->id, $this->table, $relation);
    }
}
