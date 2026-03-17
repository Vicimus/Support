<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

interface LeadsService
{
    /**
     * Retrieve the dates of leads created associated with a vehicle
     *
     * @return string[][]
     */
    public function getLeadDatesPerVehicle(): array;
}
