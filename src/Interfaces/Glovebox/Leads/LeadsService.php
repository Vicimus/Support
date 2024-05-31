<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

/**
 * Interface LeadsService
 */
interface LeadsService
{
    /**
     * Retrieve the dates of leads created associated with a vehicle
     *
     * @return mixed[]
     */
    public function getLeadDatesPerVehicle(): array;
}
