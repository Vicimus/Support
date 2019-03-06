<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\Support\Exceptions\RestException;

/**
 * Interface PurlEvents
 */
interface PurlEvents
{
    /**
     * Handle the event being sent in from the Purl
     *
     * @param PurlEvent $event The event code
     *
     * @return bool
     *
     * @throws RestException
     */
    public function handle(PurlEvent $event): bool;

    /**
     * Add a temperature to the records
     *
     * @param PurlInteraction $modify Modification information
     * @param PurlFiredEvent  $event  The purl event
     *
     * @return void
     */
    public function temperature(PurlInteraction $modify, PurlFiredEvent $event): void;
}
