<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface CriteriaContract
 */
interface CriteriaContract
{
    /**
     * Retrieve the payload for setting the campaign biddable group criteria
     * @return string[]|array
     */
    public function biddable(): array;

    /**
     * Retrieve the keywords for setting the ad group criteria
     * @return string[]|array
     */
    public function keywords(): array;

    /**
     * Retrieve the payload for setting the campaign negative group criteria
     * @return string[]|array
     */
    public function negative(): array;

    /**
     * Retrieve the payload for setting the campaign criteria
     * @return string[]|array
     */
    public function payload(): array;
}
