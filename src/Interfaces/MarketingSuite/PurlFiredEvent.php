<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface PurlFiredEvent
{
    public function __construct(int $campaign, int $customer, ?string $additional = null);

    /**
     * Get the additional details for the event
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
     */
    public function referer(?string $referer = null): PurlFiredEvent | string;

    /**
     * Get the temperature associated with the event
     */
    public function temperature(): int;
}
