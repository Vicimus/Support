<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

/**
 * Interface LeadType
 *
 * @property int $id
 */
interface LeadRecord
{
    /**
     * Send the lead to whoever
     *
     */
    public function send(): void;
}
