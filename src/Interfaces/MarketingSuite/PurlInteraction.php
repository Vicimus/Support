<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Shared\Contracts\Prospect;

/**
 * Interface PurlInteraction
 *
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
     * @return int
     */
    public function campaign(): int;
    /**
     * The customer id
     * @return int
     */
    public function customer(): int;


    /**
     * An explanation of the action
     * @return string
     */
    public function explanation(): ?string;

    /**
     * Retrieve the prospect associated with the interaction
     * @return Prospect
     */
    public function prospect(): Prospect;

    /**
     * The score for the interaction
     * @return int
     */
    public function temp(): int;
}
