<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use DateTime;

/**
 * Interface Lockable
 */
interface Lockable
{
    /**
     * Retrieve the items locked at timestamp
     */
    public function lockedAt(): ?DateTime;

    /**
     * Retrieve the id of the locking user
     */
    public function lockedBy(): ?int;
}
