<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use Carbon\Carbon;
use DateTime;

/**
 * Interface Lockable
 */
interface Lockable
{
    /**
     * Retrieve the items locked at timestamp
     * @return DateTime|null
     */
    public function lockedAt(): ?DateTime;

    /**
     * Retrieve the id of the locking user
     * @return int|null
     */
    public function lockedBy(): ?int;
}
