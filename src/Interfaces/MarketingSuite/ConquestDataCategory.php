<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\Support\Classes\ConquestDataCategoryInfo;

interface ConquestDataCategory
{
    /**
     * Get info about this category
     */
    public function info(ConquestDataSourceRepository $repo): ConquestDataCategoryInfo;
}
