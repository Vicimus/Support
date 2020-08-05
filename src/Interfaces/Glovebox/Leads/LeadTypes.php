<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

use Vicimus\Support\Interfaces\Glovebox\EloquentRepository;

/**
 * Interface LeadTypes
 */
interface LeadTypes extends EloquentRepository
{
    /**
     * Get a lead type by type slug
     *
     * @param string $type The type to get
     *
     * @return LeadType
     */
    public function byType(string $type): LeadType;

    /**
     * Create a new type record
     *
     * @param mixed[] $attributes The attributes
     *
     * @return LeadType
     */
    public function create(array $attributes): LeadType;

    /**
     * Get the type by id
     *
     * @param int $id The id of the type to get
     *
     * @return LeadType|null
     */
    public function find(int $id): ?LeadType;

    /**
     * Just get the first type in the database
     *
     * @return LeadType
     */
    public function first(): LeadType;

    /**
     * Find or create
     *
     * @param mixed[] $attributes The attributes
     *
     * @return LeadType
     */
    public function firstOrCreate(array $attributes): LeadType;
}
