<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Shared\Contracts\Prospect;
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
 * @property bool|int $send_email
 * @property bool|int $send_letter
 * @property bool|int $send_voice
 * @property ScriptContract $script
 * @property mixed $letter
 * @property mixed $postcard
 * @property string $subject
 * @property Carbon $email_at
 * @property Carbon $print_at
 * @property bool $send_optimization
 * @property bool|int $send_bdc
 * @property bool|int $send_sms
 * @property Carbon $print_request
 * @property Carbon $sms_at
 * @property bool|int $send_postcard
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
     * Retrieve an asset from the campaign
     *
     * @param string $type The type of the asset
     * @return AssetContract|null
     */
    public function asset(string $type): ?AssetContract;

    /**
     * A campaign has many assets
     * @return MorphMany
     */
    public function assets(): MorphMany;

    /**
     * Retrieve a Carbon Copy for a campaign
     *
     * @return Prospect|null
     */
    public function copy(): ?Prospect;

    /**
     * Retrieve the form id to use for the purl
     *
     * @return int
     */
    public function formId(): ?int;

    /**
     * Has the campaign portfolio been modified at all, even a single time
     * @return bool
     */
    public function hasPortfolioBeenModified(): bool;

    /**
     * Is the campaign email only
     *
     * @return bool
     */
    public function isEmailOnly(): bool;

    /**
     * Is the campaign purl only
     *
     * @return bool
     */
    public function isPurlOnly(): bool;

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
     * Return an array of campaign medium toggles with their associated datetime value
     *
     * @return mixed[]
     */
    public function mediumAssociations(): array;

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
     * Find a property value or return null
     *
     * @param string          $name    The property to look for
     * @param string|int|bool $default The default value to return if the property doesn't exist
     *
     * @return int|string|bool|null
     */
    public function property(string $name, $default = null);

    /**
     * A campaign has many prospects
     *
     * @return HasMany
     */
    public function prospects(): HasMany;

    /**
     * Check if there is a property value
     *
     * @param string               $property The property to set
     * @param string|int|bool|null $value    If set, will record a property rather than get
     * @param bool                 $hidden   The hidden state of a property
     *
     * @return void
     *
     * @throws JsonException
     */
    public function record(string $property, $value = null, bool $hidden = false): void;

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

    /**
     * Campaign version
     * @return int
     */
    public function version(): int;
}
