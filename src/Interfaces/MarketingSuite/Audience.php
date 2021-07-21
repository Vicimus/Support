<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\Creatable;

/**
 * Interface Audience
 * @property int $id
 * @property int $estimated
 * @property bool $preset
 * @property Audience $extension
 * @property Campaign|SourceRecord|mixed $audienceable
 */
interface Audience extends HasProperties
{
    /**
     * Get the thing that owns this audience
     *
     * @return MorphTo
     */
    public function audienceable(): MorphTo;

    /**
     * Retrieve the criteria from the audience
     * @return CriteriaContract|null
     */
    public function criteria(): ?CriteriaContract;

    /**
     * An audience may extend another audience as AudienceContract;

     *
     * @return BelongsTo|self
     */
    public function extension(): BelongsTo;

    /**
     * A unique hash to describe the audience state
     *
     * @return string
     */
    public function hash(): string;

    /**
     * Is extending another audience or not
     *
     * @return bool
     */
    public function isExtending(): bool;

    /**
     * Get a name for this audience
     *
     * @return string
     */
    public function name(): string;

    /**
     * Get a target instance representing who the audience targets
     *
     * @param null|Creatable $asset The asset being targeted
     * @param bool           $pure  Flag to manipulate the target values
     *
     * @return Target
     */
    public function target(?Creatable $asset, bool $pure = true): Target;
}
