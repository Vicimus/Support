<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\Support\Classes\ConquestDataSourceInfo;

/**
 * Interface ConquestDataSource
 */
interface ConquestDataSource
{
    /**
     * Get the category for this data source
     *
     * @return string
     */
    public function category(): string;

    /**
     * An informative description
     *
     * @return string
     */
    public function description(): string;

    /**
     * Get information on this data source
     *
     * @return ConquestDataSourceInfo
     */
    public function info(): ConquestDataSourceInfo;

    /**
     * The name of the data source as it should be displayed to clients
     *
     * @return string
     */
    public function name(): string;
}
