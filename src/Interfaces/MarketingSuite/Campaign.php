<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
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
 * @property Carbon $start
 * @property Carbon $end
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property string $live_site
 * @property string $purl_background
 * @property bool $send_email
 * @property bool $send_letter
 * @property bool $send_voice
 */
interface Campaign extends Eloquent
{
    /**
     * A campaign has many acknowledgements
     *
     * @return MorphMany
     */
    public function acknowledgements(): MorphMany;

    /**
     * Has the campaign portfolio been modified at all, even a single time
     * @return bool
     */
    public function hasPortfolioBeenModified(): bool;

    /**
     * This method should return if the campaign is utilizing a specific
     * medium. Is it sending letters, sending emails, using facebook carousel,
     * etc.
     *
     * @param string $slug The asset type slug
     *
     * @return bool
     */
    public function medium(string $slug): bool;

    /**
     * Get the OEM for this campaign
     * @return string
     */
    public function oem(): string;

    /**
     * Get the assets associated with this campaign
     *
     * @return Asset[]
     */
    public function portfolio(): array;

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
