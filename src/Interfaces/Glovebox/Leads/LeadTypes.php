<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

use Vicimus\Support\Interfaces\Glovebox\EloquentRepository;

interface LeadTypes extends EloquentRepository
{
    /**
     * Get a lead type by type slug
     */
    public function byType(string $type): LeadType;

    /**
     * Create a new type record
     *
     * @param string[]|string[][] $attributes The attributes
     */
    public function create(array $attributes): LeadType;

    /**
     * Get the type by id
     */
    public function find(int $id): ?LeadType;

    /**
     * Just get the first type in the database
     */
    public function first(): LeadType;

    /**
     * Find or create
     *
     * @param string[]|string[][] $attributes The attributes
     */
    public function firstOrCreate(array $attributes): LeadType;
}
