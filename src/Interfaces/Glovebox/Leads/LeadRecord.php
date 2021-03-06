<?php declare(strict_types = 1);

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
     * @return void
     */
    public function send(): void;
}
