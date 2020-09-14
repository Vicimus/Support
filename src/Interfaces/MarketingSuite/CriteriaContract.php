<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface CriteriaContract
 */
interface CriteriaContract
{
    /**
     * Retrieve the payload for setting the campaign group criteria
     * @return array
     */
    public function groupPayload(): array;

    /**
     * Retrieve the keywords for setting the ad group criteria
     * @return array
     */
    public function keywords(): array;

    /**
     * Retrieve the payload for setting the campaign criteria
     * @return array
     */
    public function payload(): array;
}
