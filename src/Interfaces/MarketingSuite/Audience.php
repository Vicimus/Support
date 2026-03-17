<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $estimated
 * @property bool $preset
 * @property Audience $extension
 * @property Campaign|SourceRecord $audienceable
 */
interface Audience extends HasProperties
{
    /**
     * Get the thing that owns this audience
     */
    public function audienceable(): MorphTo;

    /**
     * Retrieve the criteria from the audience
     */
    public function criteria(): ?CriteriaContract;

    /**
     * An audience may extend another audience as AudienceContract;
     */
    public function extension(): BelongsTo;

    /**
     * A unique hash to describe the audience state
     */
    public function hash(): string;

    /**
     * Is extending another audience or not
     */
    public function isExtending(): bool;

    /**
     * Get a name for this audience
     */
    public function name(): string;

    /**
     * Retrieve the remote id used by the audience
     */
    public function remoteId(): ?int;

    /**
     * Get a target instance representing who the audience targets
     */
    public function target(?string $placement, bool $pure = true): Target;
}
