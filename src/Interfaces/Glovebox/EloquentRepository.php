<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface EloquentRepository
 */
interface EloquentRepository
{
    /**
     * Create a new type record
     *
     * @param mixed[] $attributes The attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Get the type by id
     *
     * @param int $id The id of the type to get
     *
     * @return mixed|null
     */
    public function find(int $id);

    /**
     * Find or create
     *
     * @param mixed[] $attributes The attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes);
}
