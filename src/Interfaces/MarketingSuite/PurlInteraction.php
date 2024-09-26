<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * @property int $campaign
 * @property int $customer
 * @property int $temp
 * @property string $explanation
 * @property bool $testing
 */
interface PurlInteraction
{
    /**
     * The campaign id
     */
    public function campaign(): int;

    /**
     * The customer id
     */
    public function customer(): int;

    /**
     * An explanation of the action
     */
    public function explanation(): ?string;

    /**
     * Retrieve the prospect associated with the interaction
     */
    public function prospect(): Prospect;

    /**
     * The score for the interaction
     */
    public function temp(): int;
}
