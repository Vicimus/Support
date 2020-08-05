<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QBuilder;
use Vicimus\Support\Interfaces\Glovebox\Promotions\PromotionIncentive;

/**
 * Class Promotions
 */
interface Promotions
{
    /**
     * @param int $incentiveId The incentive id to find
     *
     * @return PromotionIncentive
     */
    public function incentive(int $incentiveId): PromotionIncentive;

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
