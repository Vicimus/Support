<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use DateTimeInterface;
use Illuminate\Support\Collection;
use Vicimus\Support\Classes\ConquestCompatibilityMatrix;
use Vicimus\Support\Classes\ConquestDataSourceInfo;
use Vicimus\Support\Classes\Grouping;
use Vicimus\Support\Exceptions\RemoteAdGroupDoesNotExistException;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\BudgetException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\StatusException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\UpdateException;
use Vicimus\Support\Interfaces\Store;

/**
 * Interface ConquestDataSource
 */
interface ConquestDataSource extends PropertyProvider
{
    /**
     * Unpause a campaign, setting it live at it's source
     *
     * @param SourceRecord $source The local source
     *
     * @return void
     * @throws DataSourceException
     */
    public function activate(SourceRecord $source): void;

    /**
     * Determine if a source has been approved to go live
     *
     * @param Campaign     $campaign The campaign containing the assets
     * @param SourceRecord $source   The related data source
     *
     * @return bool
     */
    public function approved(Campaign $campaign, SourceRecord $source): bool;

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
     *
     * @throws DataSourceException
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
     * Create a campaign for the source
     *
     * @param HasSource    $campaign The local campaign
     * @param SourceRecord $source   The campaign source
     *
     * @return void
     * @throws DataSourceException
     */
    public function create(HasSource $campaign, SourceRecord $source): void;

    /**
     * Retrieve the credentials for a source from the provided store
     *
     * @param Store $store The store
     *
     * @return ConquestDataSourceCredentials
     */
    public function credentials(Store $store): ConquestDataSourceCredentials;

    /**
     * An informative description
     *
     * @return string
     */
    public function description(): string;

    /**
     * A campaign was deleted and the source needs to clean up after itself.
     * The name clean was already taken.
     *
     * @param HasSource    $campaign The campaign that was deleted
     * @param SourceRecord $record   The data source record
     *
     * @return void
     *
     * @throws DataSourceException
     */
    public function destroy(HasSource $campaign, SourceRecord $record): void;

    /**
     * Disable multiple assets from a data sources campaign
     *
     * @param SourceRecord $source        The data source
     * @param string[]     $adIdsToRemove The array of data source ad ids to remove
     *
     * @return void
     * @throws RemoteAdGroupDoesNotExistException
     */
    public function disable(SourceRecord $source, array $adIdsToRemove): void;

    /**
     * Estimate the audience size
     *
     * @see https://developers.facebook.com/docs/marketing-api/reference/ad-campaign/delivery_estimate/
     *
     * @param Audience     $audience The audience to estimate
     * @param SourceRecord $record   The source record
     *
     * @return int
     *
     * @throws BudgetException
     * @throws DataSourceException
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
     * Check to make sure the data source has valid credentials
     *
     * @param SourceRecord $sourceRecord The source to validate
     *
     * @return bool
     */
    public function hasValidCredentials(SourceRecord $sourceRecord): bool;

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
     * Mediums on the sourceable item where changed
     *
     * @param SourceRecord $source The source related to the update
     *
     * @return void
     */
    public function mediumsUpdated(SourceRecord $source): void;

    /**
     * The name of the data source as it should be displayed to clients
     *
     * @return string
     */
    public function name(): string;

    /**
     * Add multiple assets to a data sources campaign
     *
     * @param HasSource    $campaign The campaign
     * @param SourceRecord $source   The data source
     * @param ResultSet    $results  The actions results
     * @param bool         $basic    Flag to just do the basic launch process
     *
     * @return void
     */
    public function process(HasSource $campaign, SourceRecord $source, ResultSet $results, bool $basic = false): void;

    /**
     * Regenerate the ad placements for the provided source/assets
     *
     * @param SourceRecord $source The source the assets belong to
     * @param Collection   $assets The assets to regenerate for
     *
     * @return void
     */
    public function regenerate(SourceRecord $source, Collection $assets): void;

    /**
     * A data source can add to a report about the individual ads
     *
     * @param SourceRecord           $source The source record
     * @param DateTimeInterface|null $date   The date to collect info for (if null then today)
     * @param DateTimeInterface|null $end    The end date to collect info for (if null then today)
     *
     * @return Collection
     * @throws DataSourceException
     */
    public function reportAds(
        SourceRecord $source,
        ?DateTimeInterface $date = null,
        ?DateTimeInterface $end = null
    ): Collection;

    /**
     * A data source can add to a report about the campaign
     *
     * @param SourceRecord           $source The source record
     * @param ConquestReport         $report The report to build on
     * @param DateTimeInterface|null $date   The date to collect info for (if null then today)
     * @param DateTimeInterface|null $end    The end date to collect info for (if null then today)
     *
     * @return void
     *
     * @throws DataSourceException
     */
    public function reportCampaign(
        SourceRecord $source,
        ConquestReport $report,
        ?DateTimeInterface $date = null,
        ?DateTimeInterface $end = null
    ): void;

    /**
     * Reschedule a campaign
     *
     * @param SourceRecord $source  The data source
     * @param string[]     $payload The update payload
     * @return void
     *
     * @throws DataSourceException
     */
    public function reschedule(SourceRecord $source, array $payload): void;

    /**
     * Method triggered on source initial save
     *
     * @param SourceRecord $source The source saved
     *
     * @return void
     */
    public function save(SourceRecord $source): void;

    /**
     * Handle any pre processing setup required by the source
     *
     * @param HasSource $hasSource The local campaign
     * @param ResultSet $resultSet The results to process
     *
     * @return void
     */
    public function setup(HasSource $hasSource, ResultSet $resultSet): void;

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
     * Update an updated audience, at it's source
     *
     * @param Audience     $audience The audience which was updated
     * @param SourceRecord $source   The source the audience relates to
     *
     * @return void
     * @throws UpdateException
     */
    public function update(Audience $audience, SourceRecord $source): void;

    /**
     * Get a validator to validate certain things
     * @return ConquestDataSourceValidator
     */
    public function validator(): ConquestDataSourceValidator;

    /**
     * Verify the connection to the source
     *
     * @param int $storeId The store id to verify
     *
     * @return ConquestDataSourceVerificationResponse
     */
    public function verify(int $storeId): ConquestDataSourceVerificationResponse;
}
