<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as IlluminateCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Vicimus\Support\Database\Model;
use Vicimus\Support\Interfaces\MarketingSuite\Campaign as BaseCampaign;

/**
 * @property int                          $id
 * @property Filter                       $filter
 * @property int                          $store_id
 * @property Collection[]                  $collections
 * @property IlluminateCollection|Model   $approvals
 * @property Carbon                       $start
 * @property Carbon                       $end
 * @property string                       $oem
 * @property bool                         $send_email
 * @property bool                         $send_letter
 * @property bool                         $send_voice
 * @property string                       $title
 * @property string                       $subject
 * @property int                          $user_id
 * @property int                          $lead_type_id
 * @property Stats                        $stats
 * @property string                       $parent_url
 * @property IlluminateCollection|Model[] $excludes
 * @property IlluminateCollection|Model[] $departments
 * @property Carbon                       $created_at
 * @property Carbon                       $updated_at
 * @property bool                         $live_site
 * @property string                       $purl_background
 * @property string[]                     $purl_dates
 * @property string                       $description
 * @property string                       $sign_off_name
 * @property string                       $sign_off_title
 * @property Carbon                       $launched_at
 * @property Carbon                       $printed_atd
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
     */
    public function batches(): HasMany;

    /**
     * Departments
     */
    public function departments(): MorphToMany;

    /**
     * Campaigns allowed to share customers
     */
    public function includes(): HasMany;

    /**
     * Check if a campaign is bdc only
     */
    public function isBdcOnly(): bool;

    /**
     * Check if a campaign is email only
     */
    public function isEmailOnly(): bool;

    /**
     * Is the campaign letter only
     */
    public function isLetterOnly(): bool;

    /**
     * Is the campaign sms only
     */
    public function isSmsOnly(): bool;

    /**
     * Is the campaign voice only
     */
    public function isVoiceOnly(): bool;

    /**
     * The logs method
     */
    public function logs(): MorphMany;

    /**
     * A campaign can have many notes associated with it
     */
    public function notes(): MorphMany;

    /**
     * A campaign may have a staggered medium schedule
     */
    public function staggers(): ?HasMany;

    /**
     * Campaigns have stats
     */
    public function stats(): HasOne;

    /**
     * Determine if customer preference should be used
     */
    public function useCustomerPreference(): bool;

    /**
     * Determine if bounced customers should be excluded
     *
     * @param bool $default The default value to use if explicitly set
     */
    public function useExcludeBounced(bool $default): bool;

    public function useExcludeEngaged(): bool;

    /**
     * Determine if the emails should only go to active customers
     */
    public function useOnlyEmailActive(): bool;

    /**
     * Determine if launch process should scale mediums
     */
    public function useScaleMediums(): bool;
}
