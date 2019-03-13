<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Vicimus\Support\Interfaces\Eloquent;

/**
 * Interface Campaign
 *
 * @property int $id
 * @property string $oem
 * @property string $title
 * @property int $store_id
 * @property int $lead_type_id
 */
interface Campaign extends Eloquent
{
    /**
     * Get collections associated with a campaign
     *
     * @return MorphMany
     */
    public function collections(): MorphMany;

    /**
     * Temperatures exist on a campaign
     *
     * @return MorphMany
     */
    public function temperatures(): MorphMany;
}
