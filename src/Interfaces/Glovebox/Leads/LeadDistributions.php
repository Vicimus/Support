<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

use Vicimus\Support\Interfaces\Glovebox\EloquentRepository;

/**
 * Interface LeadDistributions
 */
interface LeadDistributions extends EloquentRepository
{
    /**
     * Get a distribution by assigned type
     *
     * @param LeadType $type The type to get by
     *
     * @return LeadDistribution|null
     */
    public function byType(LeadType $type): ?LeadDistribution;

    /**
     * Create a new type record
     *
     * @param mixed[] $attributes The attributes
     *
     * @return LeadDistribution
     */
    public function create(array $attributes): LeadDistribution;

    /**
     * Get the type by id
     *
     * @param int $id The id of the type to get
     *
     * @return LeadDistribution|null
     */
    public function find(int $id): ?LeadDistribution;

    /**
     * Find or create
     *
     * @param mixed[] $attributes The attributes
     *
     * @return LeadDistribution
     */
    public function firstOrCreate(array $attributes): LeadDistribution;
}
