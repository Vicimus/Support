<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use DateTime;
use Vicimus\Support\Database\Model;

/**
 * Campaign Model
 *
 * @property int $id
 * @property Filter $filter
 * @property int $store_id
 * @property \Bumper\Models\Collection[] $collections
 * @property \Illuminate\Database\Eloquent\Collection|Model $approvals
 * @property DateTime $start
 * @property DateTime $end
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
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property bool $live_site
 * @property string $purl_background
 * @property string[] $purl_dates
 * @property string $description
 * @property string $sign_off_name
 * @property string $sign_off_title
 * @property DateTime $launched_at
 * @property DateTime $printed_at
 * @property DateTime $emailed_at
 * @property DateTime $previewed_at
 * @property DateTime $expired_at
 * @property DateTime $cancelled_at
 * @property DateTime $approved_at
 * @property DateTime $print_at
 * @property DateTime $previews_at
 * @property DateTime $generated_at
 * @property bool $subject_customized
 */
interface Campaign
{
    //
}
