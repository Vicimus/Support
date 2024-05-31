<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\Support\Classes\ConquestDataCategoryInfo;

/**
 * Interface ConquestDataCategory
 */
interface ConquestDataCategory
{
    /**
     * Get info about this category
     *
     * @param ConquestDataSourceRepository $repo In case it needs data source info
     *
     */
    public function info(ConquestDataSourceRepository $repo): ConquestDataCategoryInfo;
}
