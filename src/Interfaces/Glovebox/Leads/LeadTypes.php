<?php

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

/**
 * Interface LeadTypes
 */
interface LeadTypes
{
    /**
     * Get a lead type by type slug
     *
     * @param string $type The type to get
     *
     * @return LeadType
     */
    public function byType($type);

    /**
     * Get the type by id
     *
     * @param int $id The id of the type to get
     *
     * @return LeadType|null
     */
    public function find($id);

    /**
     * Just get the first type in the database
     *
     * @return LeadType
     */
    public function first();
}
