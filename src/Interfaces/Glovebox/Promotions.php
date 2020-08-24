<?php

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Database\Eloquent\Builder;
use Vicimus\Support\Interfaces\Glovebox\Promotions\Promotion;
use Vicimus\Support\Interfaces\Glovebox\Promotions\PromotionIncentive;

/**
 * Class Promotions
 */
interface Promotions
{
    /**
     * Find a promotion based on a vehicle id
     *
     * @param int      $vehicleId   The vehicle id
     * @param int|null $promotionId Fallback promotion id
     *
     * @return Promotion|null
     */
    public function getByVehicleId($vehicleId, $promotionId = null);

    /**
     * Return the PromotionJoin query
     * @return Builder|QBuilder
     */
    public function queryJoin();

    /**
     * Return the promotion query
     * @return Builder|QBuilder
     */
    public function query();

    /**
     * @param int $incentiveId The incentive id to find
     *
     * @return PromotionIncentive
     */
    public function incentive($incentiveId);
}
