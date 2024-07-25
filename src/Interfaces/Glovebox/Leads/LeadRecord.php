<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

/**
 * @property int $id
 */
interface LeadRecord
{
    public function send(): void;
}
