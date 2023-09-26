<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QBuilder;
use Vicimus\Support\Interfaces\Glovebox\Promotions\Promotion;
use Vicimus\Support\Interfaces\Glovebox\Promotions\PromotionIncentive;

/**
 * Class Promotions
 */
interface Promotions
{
    /**
     * Get a promotion based on a vehicle id
     *
     * @param int      $vehicleId   The vehicle id
     * @param int|null $promotionId The promotion id
     *
     * @return Promotion|null
     */
    public function getByVehicleId(int $vehicleId, ?int $promotionId = null): ?Promotion;

    /**
     * @param int $incentiveId The incentive id to find
     *
     * @return PromotionIncentive|null
     */
    public function incentive(int $incentiveId): ?PromotionIncentive;

    /**
     * Return the promotion query
     * @return Builder|QBuilder
     */
    public function query();

    /**
     * Return the PromotionJoin query
     * @return Builder|QBuilder
     */
    public function queryJoin();
}
