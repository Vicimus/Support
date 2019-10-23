<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Collection;
use Vicimus\Support\Classes\ConquestCompatibilityMatrix;
use Vicimus\Support\Classes\ConquestDataSourceInfo;
use Vicimus\Support\Classes\Grouping;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\StatusException;

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
     * If a budget has been set or updated, we need to pass it along to the
     * data source for it to inform it's API that the budget has increased.
     *
     * @param Audience     $audience The audience involved
     * @param SourceRecord $record   The source record
     * @param int          $amount   The amount
     *
     * @return void
     */
    public function budget(Audience $audience, SourceRecord $record, int $amount): void;

    /**
     * Get the category for this data source
     *
     * @return string
     */
    public function category(): string;

    /**
     * Clean up after an audience
     *
     * @param Audience     $audience The audience that is being deleted
     * @param SourceRecord $record   The record
     *
     * @return void
     */
    public function clean(Audience $audience, SourceRecord $record): void;

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
     * Estimate the audience size
     *
     * @see https://developers.facebook.com/docs/marketing-api/reference/ad-campaign/delivery_estimate/
     *
     * @param Audience     $audience The audience to estimate
     * @param SourceRecord $record   The source record
     *
     * @return int
     */
    public function estimate(Audience $audience, SourceRecord $record): int;

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
     * Get a font-awesome icon to use to represent this on the front end
     *
     * @return string
     */
    public function icon(): string;

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

    /**
     * A data source can add to a report about the campaign
     *
     * @param SourceRecord           $source The source record
     * @param ConquestReport         $report The report to build on
     * @param DateTimeInterface|null $date   The date to collect info for (if null then today)
     *
     * @return void
     */
    public function report(SourceRecord $source, ConquestReport &$report, ?DateTimeInterface $date = null): void;

    /**
     * Report on the status of an asset. APPROVED, PENDING or REJECTED
     *
     * @param AssetRecord $asset The asset
     *
     * @return int
     *
     * @throws StatusException
     */
    public function status(AssetRecord $asset): int;

    /**
     * Get a validator to validate certain things
     * @return ConquestDataSourceValidator
     */
    public function validator(): ConquestDataSourceValidator;
}
