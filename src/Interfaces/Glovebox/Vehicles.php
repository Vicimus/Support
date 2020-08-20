<?php

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface Vehicles
{
    /**
     * Get vehicles by id
     * @param int[]|array $ids The ids to get
     * @return Collection|Vehicle[]
     */
    public function fromIds(array $ids);

    /**
     * Get a query for the DealerLive\Inventory\Models\Vehicle model
     * @return QBuilder|Builder|Collection|Vehicle[]
     */
    public function query();
}
