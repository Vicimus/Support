<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Support\Collection;
use Vicimus\Support\Classes\ConquestDataSourceInfo;
use Vicimus\Support\Classes\Grouping;

/**
 * Interface ConquestDataSource
 */
interface ConquestDataSource
{
    /**
     * Get an array of asset slugs supported by the source
     *
     * @return string[]
     */
    public function assets(): array;

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
     * Handle launching assets from a specific conquest campaign
     *
     * @param Campaign     $campaign The conquest campaign instance
     * @param SourceRecord $source   The recorded use of a source with details
     * @param Collection   $assets   The collection of assets to launch
     *
     * @return void
     *
     * @throws DataSouceException
     */
    public function launch(Campaign $campaign, SourceRecord $source, Collection $assets): void;

    /**
     * The name of the data source as it should be displayed to clients
     *
     * @return string
     */
    public function name(): string;

    /**
     * Retrieve a list of properties which are shared across items
     *
     * @return Grouping
     */
    public function grouping(): Grouping;
}
