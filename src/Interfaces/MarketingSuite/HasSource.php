<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\HasAssetDetails;

/**
 * @property Collection|Audience[] $audiences
 * @property SourceRecord $source
 * @property int $id
 * @property string $title
 * @property Carbon $end
 * @property Carbon $start
 * @property Carbon $launched_at
 */
interface HasSource
{
    /**
     * Retrieve the display ad stats relationship
     */
    public function adStats(): Relation;

    /**
     * Retrieve the model which contains asset details
     */
    public function assetDetails(string $remoteId): ?HasAssetDetails;

    /**
     * Has many audiences
     */
    public function audiences(): MorphMany;

    /**
     * Retrieve associated datasource categories
     * @return string[]
     */
    public function categories(): array;

    /**
     * If something has a source, we must assume
     * it can also define which content it wants to use
     * for it's assets, even though this interface
     * literally has nothing to do with assets. Things
     * using hasSource require the content id be there.
     */
    public function contentId(): ?int;

    /**
     *
     * Retrieve the destination for the source placements
     *
     * i.e. Messenger/VDP/PURL
     */
    public function getDestination(): ?string;

    /**
     * Retrieve the identifier of the has source instance
     */
    public function getId(): int;

    public function getMessageTemplateId(): ?int;

    /**
     * Retrieve the error code associated with the campaign being paused
     */
    public function getPausedErrorCode(): ?int;

    /**
     * Retrieve the error code associated with the campaign being paused
     *
     * @return int|null
     */
    public function getPausedMessage(): ?string;

    /**
     * Retrieve the title of the has source instance
     */
    public function getTitle(): string;

    public function isExpired(): bool;

    /**
     * Retrieve the paused state
     */
    public function paused(): bool;

    /**
     * Retrieve the related source
     */
    public function source(): MorphOne;

    /**
     * Get the store id for this campaigns
     */
    public function storeId(): int;

    /**
     * Update the models timestamp
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     * @return bool|void
     */
    public function touch();

    /**
     * Update the model in the database.
     *
     * @param string[] $attributes The attribute updates
     * @param string[] $options    Additional options
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     * @return bool|mixed
     */
    public function update(array $attributes = [], array $options = []);
}
