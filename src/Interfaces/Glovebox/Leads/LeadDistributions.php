<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

use Vicimus\Support\Interfaces\Glovebox\EloquentRepository;

interface LeadDistributions extends EloquentRepository
{
    /**
     * Get a distribution by assigned type
     */
    public function byType(LeadType $type): ?LeadDistribution;

    /**
     * Create a new type record
     *
     * @param string[]|string[][] $attributes The attributes
     */
    public function create(array $attributes): LeadDistribution;

    /**
     * Get the type by id
     */
    public function find(int $id): ?LeadDistribution;

    /**
     * Find or create
     *
     * @param string[]|string[][] $attributes The attributes
     */
    public function firstOrCreate(array $attributes): LeadDistribution;
}
