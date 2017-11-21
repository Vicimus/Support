<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use Vicimus\Support\Database\Relations\HasManyFromAPI;

/**
 * Class ApiModel
 *
 * @package Vicimus\Support\Database
 */
class ApiModel
{
    /**
     * Model attributes
     *
     * @var mixed[]
     */
    protected $attributes = [];

    /**
     * Access to the db methods
     *
     * @var HasManyFromAPI
     */
    protected $db;

    /**
     * ApiModel constructor.
     *
     * @param HasManyFromAPI $db      Access to db functions
     * @param mixed          $payload An array of data from an API call
     */
    public function __construct(HasManyFromAPI $db, $payload)
    {
        $this->attributes = (array) $payload;
        $this->db = $db;
    }

    /**
     * Get an attribute
     *
     * @param string $property The property to get
     *
     * @return mixed|null
     */
    public function __get(string $property)
    {
        return $this->attributes[$property] ?? null;
    }

    /**
     * Set an attribute
     *
     * @param string $property The property to set
     * @param mixed  $value    The value to set it to
     *
     * @return void
     */
    public function __set(string $property, $value): void
    {
        $this->attributes[$property] = $value;
    }

    /**
     * Update a model
     *
     * @param string[] $params The parameters to update locally
     *
     * @return ApiModel
     */
    public function update(array $params): ApiModel
    {
        $this->db->update((int) $this->attributes['id'], $params);
        return $this;
    }
}
