<?php

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

/**
 * Interface LeadsService
 */
interface LeadsService
{
    /**
     * Retrieve the dates of leads created associated with a vehicle
     *
     * @return array
     */
    public function getLeadDatesPerVehicle();
}
