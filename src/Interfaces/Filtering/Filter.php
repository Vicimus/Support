<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use DateTime;
use Vicimus\Support\Interfaces\Eloquent;

/**
 * @property int $id
 * @property string $name
 * @property bool $global
 * @property bool $preset
 * @property int $user_id
 * @property int $store_id
 * @property int $group_id
 * @property int $vehicle_year_min
 * @property int $vehicle_year_max
 * @property DateTime $purchase_year_min
 * @property DateTime $purchase_year_max
 * @property int $vehicle_mileage_min
 * @property int $vehicle_mileage_max
 * @property int $last_service_min
 * @property int $last_service_max
 * @property bool $exclude_no_email
 * @property int $exclusion_days
 * @property int $scale_invites_percent
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property string $vehicle_makes
 * @property string $vehicle_models
 * @property string $postal_codes
 * @property string $cities
 * @property string $buckets
 * @property string $salespeople
 * @property string $campaigns
 * @property bool $cities_exclude
 * @property bool $buckets_exclude
 * @property int $contact_status
 * @property string $payment_type
 * @property int $maturity_months_min
 * @property int $maturity_months_max
 * @property string $smart_bucket
 * @property string $smart_bucket_months_min
 * @property string $description
 * @property string $includes
 * @property bool $limit_recent
 * @property int $displayed_total
 * @property float $displayed_cost
 * @property int $displayed_emailed
 * @property int $displayed_lettered
 * @property string $languages
 * @property string $pay_types
 * @property int $vehicle_value_min
 * @property int $vehicle_value_max
 * @property int $vehicle_rate_min
 * @property int $vehicle_rate_max
 * @property string $update_hash
 * @property string $equity_position_finance
 * @property string $equity_position_lease
 * @property int $equity_position_finance_min
 * @property int $equity_position_finance_max
 * @property int $equity_position_lease_min
 * @property int $equity_position_lease_max
 * @property int $target_sold
 * @property bool $target_sold_exclude
 * @property bool $exclusion_days_override
 * @property int $birthday
 * @property int $warranty_expiration
 * @property bool $exclude_bounced
 * @property int $ah_expiration
 * @property int $life_expiration
 * @property int $gap_expiration
 * @property int $employment_expiration
 * @property int $breakdown_expiration
 * @property int $service_expiration
 * @property int $ro_open_min
 * @property int $ro_open_max
 * @property int $ro_close_min
 * @property int $ro_close_max
 * @property int $pickup_min
 * @property int $pickup_max
 * @property string $service_advisor
 * @property string $fi_manager
 * @property bool $include_businesses
 * @property bool $vehicle_makes_exclude
 * @property bool $vehicle_models_exclude
 * @property string $emails
 * @property bool $bucket_vehicles
 * @property int $targeting
 * @property bool $active
 * @property bool $keep_additions
 * @property bool $scale_mediums
 */
interface Filter extends Eloquent
{
    /**
     * Convert all filter properties into a payload array that we can
     * use to pass to various services
     *
     * @return string[]
     */
    public function payload(): array;

    /**
     * Get an array of all the filter attributes
     *
     * @return string[]
     */
    public function toArray();
}
