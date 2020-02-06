<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
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
 * @property ScriptContract $script
 * @property mixed $letter
 * @property string $subject
 * @property Carbon $email_at
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
     * Retrieve an identifier to use for an asset slug
     *
     * @param string $type The asset type slug
     *
     * @return string
     */
    public function identifier(string $type): string;

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
     * A campaign can have one script
     *
     * @return MorphOne|ScriptContract
     */
    public function script(): MorphOne;

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
