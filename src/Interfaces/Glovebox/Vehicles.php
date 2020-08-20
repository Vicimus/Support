<?php

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface Vehicles
{
    /**
     * Get a query for the DealerLive\Inventory\Models\Vehicle model
     * @return QBuilder|Builder|Collection|Vehicle[]
     */
    public function query();
}
