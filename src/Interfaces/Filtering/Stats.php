<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use JsonSerializable;
use Vicimus\Billing\Classes\CostBreakdown;

/**
 * Interface Stats
 *
 * @property int $invites
 * @property int $emails
 * @property int $letters
 * @property int $rvms
 * @property int $excluded
 * @property int $total
 * @property CostBreakdown $cost
 * @property mixed[] $breakdown
 * @property Campaign $campaign
 * @property OptOuts $optOuts
 */
interface Stats extends JsonSerializable
{
    /**
     * Delete the model
     *
     * @return bool
     */
    public function delete(): bool;

    /**
     * Return all stats as an array of data
     * @return mixed[]
     */
    public function toArray(): array;
}
