<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface CriteriaContract
 *
 * @property array $interests
 */
interface CriteriaContract
{
    /**
     * Retrieve the payload for setting the campaign biddable group criteria
     * @return string[]|array
     */
    public function biddable(): array;

    public function getInterests(): array;

    public function locations(): array;

    /**
     * Retrieve the keywords for setting the ad group criteria
     * @return string[]|array
     */
    public function keywords(): array;
}
