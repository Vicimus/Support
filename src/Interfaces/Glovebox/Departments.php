<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Eloquent\Builder;
use Vicimus\Support\Database\Model;

interface Departments
{
    /**
     * Get a department model query builder
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     * @return Builder|Model
     */
    public function query();
}
