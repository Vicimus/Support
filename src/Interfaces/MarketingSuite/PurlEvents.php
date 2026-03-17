<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\PurlSubmissionException;

interface PurlEvents
{
    /**
     * Handle the event being sent in from the Purl
     *
     * @throws RestException
     */
    public function handle(PurlEvent $event): bool;

    /**
     * Handle purl submissions
     *
     * @param string[] $request The request payload
     * @param int|null $lead    The lead id to be populated
     * @param bool     $testing Was this a testing submission
     *
     * @throws PurlSubmissionException
     * @throws RestException
     */
    public function submission(array $request, ?int &$lead = null, bool $testing = false): LeadConfirmation;

    /**
     * Add a temperature to the records
     */
    public function temperature(PurlInteraction $modify, PurlFiredEvent $event): void;
}
