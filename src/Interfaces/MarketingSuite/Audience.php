<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Shared\Models\Audiences\Property;

/**
 * Interface Audience
 * @property int $id
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
     * A unique hash to describe the audience state
     *
     * @return string
     */
    public function hash(): string;

    /**
     * Get a name for this audience
     *
     * @return string
     */
    public function name(): string;

    /**
     * Get a target instance representing who the audience targets
     *
     * @return Target
     */
    public function target(): Target;
}
