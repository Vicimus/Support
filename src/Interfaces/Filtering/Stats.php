<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use JsonSerializable;
use Vicimus\Support\Interfaces\Billing\CostBreakdownContract;

/**
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
 * @property int $invites
 * @property int $emails
 * @property int $letters
 * @property int $rvms
 * @property int $excluded
 * @property int $total
 * @property int $sms
 * @property int $postcards
 * @property mixed $cost
 * @property CostBreakdownContract|mixed[] $breakdown
 * @property Campaign $campaign
 * @property OptOuts $optOuts
 */
interface Stats extends JsonSerializable
{
    public function bdc(): int;

    public function breakdown(): CostBreakdownContract;

    public function delete(): bool;

    public function emails(): int;

    public function invites(): int;

    public function letters(): int;

    public function postcards(): int;

    public function rvms(): int;

    public function sms(): int;

    /**
     * Return all stats as an array of data
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed[]
     */
    public function toArray(): array;

    public function total(): int;
}
