<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface PurlFiredEvent
 */
interface PurlFiredEvent
{
    /**
     * Event constructor
     *
     * @param int    $campaign   The Campaign ID
     * @param int    $customer   The customer id
     * @param string $additional Additional parameters for the event
     */
    public function __construct(int $campaign, int $customer, ?string $additional = null);

    /**
     * Get the additional details for the event
     *
     */
    public function additional(): ?string;

    /**
     * Retrieve the cta id for the event
     */
    public function cta(): ?int;

    /**
     * Return the icon for the event
     */
    public function icon(): string;

    /**
     * Must return a user friendly displayable name for the event
     */
    public function name(): string;

    /**
     * Get the referer
     *
     * @param string|null $referer If not null will set the referer else return it
     *
     */
    public function referer(?string $referer = null): string|PurlFiredEvent;

    /**
     * Get the temperature associated with the event
     *
     */
    public function temperature(): int;
}
