<?php

namespace Vicimus\Support\Interfaces\Glovebox;

use Vicimus\Support\Interfaces\Glovebox\Leads\LeadPerson;
use Vicimus\Support\Interfaces\Glovebox\Leads\LeadType;

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
    public function find($id);

    /**
     * Find or create
     *
     * @param mixed[] $attributes The attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes);
}
