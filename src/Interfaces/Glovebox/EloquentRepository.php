<?php

declare(strict_types=1);

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
     */
    public function create(array $attributes): mixed;

    /**
     * Get the type by id
     *
     * @param int $id The id of the type to get
     *
     */
    public function find(int $id): mixed;

    /**
     * Find or create
     *
     * @param mixed[] $attributes The attributes
     *
     */
    public function firstOrCreate(array $attributes): mixed;
}
