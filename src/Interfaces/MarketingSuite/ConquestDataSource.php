<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Support\Collection;
use Vicimus\Support\Classes\ConquestCompatibilityMatrix;
use Vicimus\Support\Classes\ConquestDataSourceInfo;
use Vicimus\Support\Classes\Grouping;

/**
 * Interface ConquestDataSource
 */
interface ConquestDataSource
{
    /**
     * Get an array of asset slugs supported by the source. The index
     * should be the CID code to use when generating identifiers
     *
     * @see https://vicimus.atlassian.net/wiki/spaces/SP/pages/578519054/Functionality+LP
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
     * A data source has an external code assigned to it by the product team.
     * This method must return that code.
     *
     * @see https://vicimus.atlassian.net/wiki/spaces/SP/pages/578519054/Functionality+LP
     *
     * @return int
     */
    public function code(): int;

    /**
     * Get a matrix of compatibility information
     *
     * @return ConquestCompatibilityMatrix
     */
    public function compatibility(): ConquestCompatibilityMatrix;

    /**
     * An informative description
     *
     * @return string
     */
    public function description(): string;

    /**
     * Get the asset grouping for this data source. The main reason this
     * was created was for us to be able to handle shared properties across
     * many assets. Specifically, Facebook has many assets that all share
     * specific properties.
     *
     * @return Grouping
     */
    public function grouping(): Grouping;

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
     * @throws DataSourceException
     */
    public function launch(Campaign $campaign, SourceRecord $source, Collection $assets): void;

    /**
     * The name of the data source as it should be displayed to clients
     *
     * @return string
     */
    public function name(): string;
}
