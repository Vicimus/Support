<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QBuilder;
use Vicimus\Support\Interfaces\Glovebox\Promotions\Promotion;
use Vicimus\Support\Interfaces\Glovebox\Promotions\PromotionIncentive;

interface Promotions
{
    /**
     * Get a promotion based on a vehicle id
     */
    public function getByVehicleId(int $vehicleId, ?int $promotionId = null): ?Promotion;

    public function incentive(int $incentiveId): ?PromotionIncentive;

    /**
     * Return the promotion query
     */
    public function query(): Builder|QBuilder;

    /**
     * Return the PromotionJoin query
     */
    public function queryJoin(): Builder|QBuilder;
}
