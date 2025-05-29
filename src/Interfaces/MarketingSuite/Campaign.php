<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use JsonException;
use Vicimus\Support\Interfaces\Eloquent;

/**
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
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
 * @property bool|int $send_optimization
 * @property bool|int $send_bdc
 * @property bool|int $send_sms
 * @property Carbon $print_request
 * @property Carbon $sms_at
 * @property bool|int $send_postcard
 */
interface Campaign extends Eloquent, Placeholderable
{
    /**
     * A campaign has many acknowledgements
     */
    public function acknowledgements(): MorphMany;

    /**
     * Retrieve an asset from the campaign
     */
    public function asset(string $type): ?AssetContract;

    /**
     * A campaign has many assets
     */
    public function assets(): MorphMany;

    /**
     * Retrieve a Carbon Copy for a campaign
     */
    public function copy(): ?Prospect;

    /**
     * Retrieve the form id to use for the purl
     */
    public function formId(): ?int;

    /**
     * Has the campaign portfolio been modified at all, even a single time
     */
    public function hasPortfolioBeenModified(): bool;

    /**
     * Is the campaign email only
     */
    public function isEmailOnly(): bool;

    /**
     * Is the campaign purl only
     */
    public function isPurlOnly(): bool;

    public function leadTypeId(): ?int;

    /**
     * This method should return if the campaign is utilizing a specific
     * medium. Is it sending letters, sending emails, using facebook carousel,
     * etc.
     */
    public function medium(string $slug): bool;

    /**
     * Return an array of campaign medium toggles with their associated datetime value
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed[]
     */
    public function mediumAssociations(): array;

    /**
     * Get the OEM for this campaign
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
     */
    public function property(string $name, mixed $default = null): mixed;

    /**
     * A campaign has many prospects
     */
    public function prospects(): HasMany;

    /**
     * Check if there is a property value
     *
     * @throws JsonException
     */
    public function record(string $property, mixed $value = null, bool $hidden = false): void;

    /**
     * A campaign can have one script
     *
     * @return MorphOne|ScriptContract
     */
    public function script(): MorphOne;

    /**
     * Get the store id for this campaigns
     */
    public function storeId(): int;

    /**
     * Temperatures exist on a campaign
     */
    public function temperatures(): MorphMany;

    /**
     * Campaign version
     */
    public function version(): int;
}
