<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property string $parent_url
 * @property int $purl_domain_id
 * @property int $user_id
 */
interface Campaign extends Eloquent
{
    /**
     * Stored assets through Asset Creator. Introduced with Conquest,
     * this will eventually be used with Retention as well.
     *
     * @return MorphMany
     */
    public function assets(): MorphMany;

    /**
     * Get collections associated with a campaign
     *
     * @return HasMany|MorphMany
     */
    public function collections();

    /**
     * Get the store id for this campaigns
     *
     * @return int
     */
    public function storeId(): int;

    /**
     * Temperatures exist on a campaign
     *
     * @return MorphMany
     */
    public function temperatures(): MorphMany;
}
