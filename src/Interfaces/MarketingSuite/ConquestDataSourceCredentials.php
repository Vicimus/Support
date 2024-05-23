<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface ConquestDataSourceCredentials
 */
interface ConquestDataSourceCredentials
{
    /**
     * Determine if the data source has the required credentials to make a request
     */
    public function valid(): bool;
}
