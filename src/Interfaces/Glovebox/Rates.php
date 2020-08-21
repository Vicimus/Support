<?php

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface Rates
 */
interface Rates
{
    /**
     * Get a rate query
     * @return Builder
     */
    public function query();
}
