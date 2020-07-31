<?php

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Database\Eloquent\Builder;
use Vicimus\Support\Interfaces\Glovebox\Promotions\PromotionIncentive;

/**
 * Class Promotions
 */
interface Promotions
{
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
