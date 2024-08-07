<?php

declare(strict_types=1);

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

interface ConquestDataSource extends PropertyProvider
{
    /**
     * Unpause a campaign, setting it live at it's source
     * @throws DataSourceException
     */
    public function activate(SourceRecord $source): void;

    /**
     * Determine if a source has been approved to go live
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
     */
    public function budget(Audience $audience, SourceRecord $record, int $amount): void;

    /**
     * Get the category for this data source
     */
    public function category(): string;

    /**
     * Clean up after an audience
     *
     * @throws DataSourceException
     */
    public function clean(Audience $audience, SourceRecord $record): void;

    /**
     * A data source has an external code assigned to it by the product team.
     * This method must return that code.
     *
     * @see https://vicimus.atlassian.net/wiki/spaces/SP/pages/578519054/Functionality+LP
     */
    public function code(): int;

    /**
     * Get a matrix of compatibility information
     */
    public function compatibility(): ConquestCompatibilityMatrix;

    /**
     * Create a campaign for the source
     * @throws DataSourceException
     */
    public function create(HasSource $campaign, SourceRecord $source): void;

    /**
     * Retrieve the credentials for a source from the provided store
     */
    public function credentials(Store $store): ConquestDataSourceCredentials;

    /**
     * An informative description
     */
    public function description(): string;

    /**
     * A campaign was deleted and the source needs to clean up after itself.
     * The name clean was already taken.
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
     * @throws RemoteAdGroupDoesNotExistException
     */
    public function disable(SourceRecord $source, array $adIdsToRemove): void;

    /**
     * Estimate the audience size
     *
     * @see https://developers.facebook.com/docs/marketing-api/reference/ad-campaign/delivery_estimate/
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
     */
    public function grouping(): Grouping;

    /**
     * Check to make sure the data source has valid credentials
     */
    public function hasValidCredentials(SourceRecord $sourceRecord): bool;

    /**
     * Get a font-awesome icon to use to represent this on the front end
     */
    public function icon(): string;

    /**
     * Get information on this data source
     */
    public function info(): ConquestDataSourceInfo;

    /**
     * Handle launching assets from a specific conquest campaign
     *
     * @throws DataSourceException
     */
    public function launch(Campaign $campaign, SourceRecord $source, Collection $assets): void;

    /**
     * Mediums on the sourceable item where changed
     */
    public function mediumsUpdated(SourceRecord $source): void;

    /**
     * The name of the data source as it should be displayed to clients
     */
    public function name(): string;

    /**
     * Add multiple assets to a data sources campaign
     */
    public function process(HasSource $campaign, SourceRecord $source, ResultSet $results, bool $basic = false): void;

    /**
     * Regenerate the ad placements for the provided source/assets
     */
    public function regenerate(SourceRecord $source, Collection $assets): void;

    /**
     * A data source can add to a report about the individual ads
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
     *
     * @throws DataSourceException
     */
    public function reschedule(SourceRecord $source, array $payload): void;

    /**
     * Method triggered on source initial save
     */
    public function save(SourceRecord $source): void;

    /**
     * Handle any pre processing setup required by the source
     */
    public function setup(HasSource $hasSource, ResultSet $resultSet): void;

    /**
     * Report on the status of an asset. APPROVED, PENDING or REJECTED
     *
     * @throws StatusException
     */
    public function status(AssetRecord $asset): int;

    /**
     * Update an updated audience, at it's source
     * @throws UpdateException
     */
    public function update(Audience $audience, SourceRecord $source): void;

    /**
     * Get a validator to validate certain things
     */
    public function validator(): ConquestDataSourceValidator;

    /**
     * Verify the connection to the source
     */
    public function verify(int $storeId): ConquestDataSourceVerificationResponse;
}
