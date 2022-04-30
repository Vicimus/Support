<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use JsonSerializable;

/**
 * Interface Stats
 *
 * @property int $invites
 * @property int $emails
 * @property int $letters
 * @property int $rvms
 * @property int $excluded
 * @property int $total
 * @property int $sms
 * @property int $postcards
 * @property mixed $cost
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
     * @return int
     */
    public function emails(): int;

    /**
     * @return int
     */
    public function invites(): int;

    /**
     * @return int
     */
    public function letters(): int;

    /**
     * @return int
     */
    public function postcards(): int;

    /**
     * @return int
     */
    public function rvms(): int;

    /**
     * @return int
     */
    public function sms(): int;

    /**
     * Return all stats as an array of data
     * @return mixed[]
     */
    public function toArray(): array;

    /**
     * @return int
     */
    public function total(): int;
}
