<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use DateTimeInterface;
use Illuminate\Support\Collection;
use Vicimus\Support\Classes\ConquestCompatibilityMatrix;
use Vicimus\Support\Classes\ConquestDataSourceInfo;
use Vicimus\Support\Classes\Grouping;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\BudgetException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\StatusException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\UpdateException;
use Vicimus\Support\Interfaces\Store;

/**
 * Interface ConquestDataSourceCredentials
 */
interface ConquestDataSourceCredentials
{
    /**
     * Determine if the data source has the required credentials to make a request
     * @return bool
     */
    public function valid(): bool;
}
