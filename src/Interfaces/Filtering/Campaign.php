<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Vicimus\Support\Database\Model;
use Vicimus\Support\Database\Relations\HasManyFromAPI;
use Vicimus\Support\Interfaces\MarketingSuite\Campaign as BaseCampaign;

/**
 * Campaign Model
 *
 * @property int $id
 * @property Filter $filter
 * @property int $store_id
 * @property \Bumper\Models\Collection[] $collections
 * @property \Illuminate\Database\Eloquent\Collection|Model $approvals
 * @property Carbon $start
 * @property Carbon $end
 * @property string $oem
 * @property bool $send_email
 * @property bool $send_letter
 * @property bool $send_voice
 * @property string $title
 * @property string $subject
 * @property int $user_id
 * @property int $lead_type_id
 * @property Stats $stats
 * @property string $parent_url
 * @property \Illuminate\Database\Eloquent\Collection|Model[] $excludes
 * @property \Illuminate\Database\Eloquent\Collection|Model[] $departments
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property bool $live_site
 * @property string $purl_background
 * @property string[] $purl_dates
 * @property string $description
 * @property string $sign_off_name
 * @property string $sign_off_title
 * @property Carbon $launched_at
 * @property Carbon $printed_atd
 * @property Carbon $emailed_at
 * @property Carbon $previewed_at
 * @property Carbon $expired_at
 * @property Carbon $cancelled_at
 * @property Carbon $approved_at
 * @property Carbon $print_at
 * @property Carbon $previews_at
 * @property Carbon $generated_at
 * @property bool $subject_customized
 * @property bool $has_associated
 */
interface Campaign extends BaseCampaign
{
    /**
     * A campaign can have many batches
     *
     * @return HasMany
     */
    public function batches(): HasMany;

    /**
     * Customers
     *
     * @return HasManyFromAPI
     */
    public function customers(): HasManyFromAPI;

    /**
     * Departments
     *
     * @return MorphToMany
     */
    public function departments(): MorphToMany;

    /**
     * Campaigns allowed to share customers
     *
     * @return HasMany
     */
    public function includes(): HasMany;

    /**
     * Check if an campaign is email only
     *
     * @return bool
     */
    public function isEmailOnly(): bool;

    /**
     * Is the campaign letter only
     *
     * @return bool
     */
    public function isLetterOnly(): bool;

    /**
     * Is the campaign sms only
     * @return bool
     */
    public function isSmsOnly(): bool;

    /**
     * Is the campaign voice only
     *
     * @return bool
     */
    public function isVoiceOnly(): bool;

    /**
     * The logs method
     *
     * @return HasMany
     */
    public function logs(): HasMany;

    /**
     * A campaign can have many notes associated with it
     *
     * @return MorphMany
     */
    public function notes(): MorphMany;

    /**
     * A campaign may have a staggered medium schedule
     *
     * @return HasMany|null
     */
    public function staggers(): ?HasMany;

    /**
     * Campaigns have stats
     *
     * @return HasOne
     */
    public function stats(): HasOne;
}
