<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Assets\Models\Source;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Interface HasSource
 *
 *
 */
interface HasSource
{
    /**
     * Has many assets
     * @return MorphMany|AssetModel[]
     */
    public function assets(): MorphMany;

    /**
     * Has many audiences
     *
     * @return MorphMany
     */
    public function audiences(): MorphMany;

    /**
     * Retrieve the related source
     * @return Source|BelongsTo|null
     */
    public function source();

    /**
     * Get the store id for this campaigns
     *
     * @return int
     */
    public function storeId(): int;
}
