<?php

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Eloquent\Builder;

interface ShowroomProvider
{
    /**
     * Get an array of preferred showroom trims
     *
     * @return array
     */
    public function preferred();

    /**
     * Get the Rate query for DealerLive\Inventory\Models\Argus\Rate
     * @return Builder
     */
    public function rateQuery();
}
