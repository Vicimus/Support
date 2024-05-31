<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

/**
 * Interface SourceRecord
 *
 * @property Collection|Audience[] $audiences
 * @property int $id
 * @property string $budget_type
 */
interface SourceRecord
{
    /**
     * A source has many ad sets
     */
    public function adSets(): HasMany;

    /**
     * A source has many audiences assigned to it
     *
     */
    public function audiences(): MorphMany;

    /**
     * A source can have many custom audiences
     *
     */
    public function customAudiences(): MorphMany;

    /**
     * Get an instance of the implementation
     *
     */
    public function instantiate(): ConquestDataSource;

    /**
     * Check if there is a property value
     *
     * @param string $property The property to check
     *
     */
    public function property(string $property): mixed;

    /**
     * Check if there is a property value
     *
     * @param string       $property The property to set
     * @param mixed|string $value    If set, will record a property rather than get
     *
     */
    public function record(string $property, mixed $value = null): void;

    /**
     * A source belongs to a campaign
     *
     * @return MorphTo|HasSource
     */
    public function sourceable(): MorphTo;

    /**
     * Get the store id this source is associated with
     */
    public function storeId(): int;

    /**
     * Get the type of data source this represents
     *
     */
    public function type(): string;
}
