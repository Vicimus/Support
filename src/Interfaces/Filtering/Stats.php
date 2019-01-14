<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use JsonSerializable;

/**
 * Interface Stats
 *
 * @property int $invites
 * @property int $emails
 * @property int $letters
 * @property int $excluded
 * @property int $total
 * @property float $cost
 * @property mixed[] $breakdown
 * @property Campaign $campaign
 * @property OptOuts $optOuts
 */
interface Stats extends JsonSerializable
{
    /**
     * Return all stats as an array of data
     * @return mixed[]
     */
    public function toArray(): array;
}
