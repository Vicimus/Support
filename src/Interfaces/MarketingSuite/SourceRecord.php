<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\MorphMany;
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
     * @param string $property The property to set
     * @param string $value    If set, will record a property rather than get
     *
     * @return void
     */
    public function record(string $property, $value = null): void;
}
