<?php

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

/**
 * Interface LeadMessages
 */
interface LeadMessages
{
    /**
     * Get a lead message by id
     *
     * @param int $id The id of the message to get
     *
     * @return LeadMessage
     */
    public function find($id);
}
