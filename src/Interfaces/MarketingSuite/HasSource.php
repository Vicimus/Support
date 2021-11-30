<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Interface HasSource
 *
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
     * Has many audiences
     * @return MorphMany
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
     *
     * @return int|null
     */
    public function contentId(): ?int;

    /**
     * Retrieve the identifier of the has source instance
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Retrieve the error code associated with the campaign being paused
     *
     * @return int|null
     */
    public function getPausedErrorCode(): ?int;

    /**
     * Retrieve the error code associated with the campaign being paused
     *
     * @return int|null
     */
    public function getPausedMessage(): ?string;

    /**
     * Retrieve the paused state
     * @return bool
     */
    public function paused(): bool;

    /**
     * Retrieve the related source
     * @return MorphOne|Source
     */
    public function source();

    /**
     * Get the store id for this campaigns
     * @return int
     */
    public function storeId(): int;

    /**
     * Retrieve the title of the has source instance
     *
     * @return string
     */
    public function title(): string;

    /**
     * Update the models timestamp
     * @return bool|void
     */
    public function touch();

    /**
     * Update the model in the database.
     *
     * @param string[] $attributes The attribute updates
     * @param string[] $options    Additional options
     *
     * @return bool|mixed
     */
    public function update(array $attributes = [], array $options = []);
}
