<?php declare(strict_types = 1);

namespace Vicimus\Support\Database;

use Vicimus\Support\Database\Relations\HasManyFromAPI;
use Vicimus\Support\Exceptions\ApiRelationException;

/**
 * Class ApiModel
 *
 * @property int $id
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
    protected $database;

    /**
     * ApiModel constructor.
     *
     * @param HasManyFromAPI $database Access to db functions
     * @param mixed          $payload  An array of data from an API call
     */
    public function __construct(HasManyFromAPI $database, $payload)
    {
        $this->attributes = (array) $payload;
        $this->database = $database;
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
     * Get a property
     *
     * @param string $property The property to get
     *
     * @return mixed|null
     */
    public function property(string $property)
    {
        return $this->attributes[$property] ?? null;
    }

    /**
     * Convert into an array
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Update a model
     *
     * @param string[] $params The parameters to update locally
     *
     * @throws ApiRelationException
     *
     * @return ApiModel
     */
    public function update(array $params): ApiModel
    {
        if (!($this->attributes['id'] ?? false)) {
            throw new ApiRelationException('Cannot update without an id attribute set');
        }

        if (!$this->database->update((int) $this->attributes['id'], $params)) {
            throw new ApiRelationException('Update failed');
        }

        return $this;
    }
}
