<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface CriteriaContract
 */
interface CriteriaContract
{
    /**
     * Retrieve the custom affinity audiences selected for the audience
     *
     * @return string[][]
     */
    public function getAffinity(): array;

    /**
     * Retrieve the user interests used by the audience
     * @return string[][]
     */
    public function getInterests(): array;

    /**
     * Retrieve the location targeting for the audience
     *
     * @return string[][]
     */
    public function getLocations(): array;
}
