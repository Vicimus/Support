<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

/**
 * Interface SourceRecord
 *
 * @property Collection|Audience[] $audiences
 * @property int $id
 */
interface SourceRecord
{
    /**
     * A source has many audiences assigned to it
     *
     * @return MorphMany
     */
    public function audiences(): MorphMany;

    /**
     * Get an instance of the implementation
     *
     * @return ConquestDataSource
     */
    public function instantiate(): ConquestDataSource;

    /**
     * Check if there is a property value
     *
     * @param string $property The property to check
     *
     * @return mixed
     */
    public function property(string $property);

    /**
     * Check if there is a property value
     *
     * @param string       $property The property to set
     * @param mixed|string $value    If set, will record a property rather than get
     *
     * @return void
     */
    public function record(string $property, $value = null): void;

    /**
     * A source belongs to a campaign
     *
     * @return MorphTo|HasSource
     */
    public function sourceable(): MorphTo;

    /**
     * Get the store id this source is associated with
     * @return int
     */
    public function storeId(): int;

    /**
     * Get the type of data source this represents
     *
     * @return string
     */
    public function type(): string;
}
