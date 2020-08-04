<?php

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Eloquent\Builder;
use Vicimus\Support\Database\Model;

/**
 * Interface Departments
 */
interface Departments
{
    /**
     * Get a department model query builder
     * @return Builder|Model
     */
    public function query();
}
