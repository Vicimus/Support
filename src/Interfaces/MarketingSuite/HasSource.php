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
 * @property Audience[] $audiences
 */
interface HasSource
{
    /**
     * Has many assets
     * @return MorphMany|Asset[]
     */
    public function assets(): MorphMany;

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
     * Update the models timestamp
     * @return bool|void
     */
    public function touch();
}
