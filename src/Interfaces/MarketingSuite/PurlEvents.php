<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Retention\Exceptions\PurlSubmissionException;
use Vicimus\ADF\ADFInfo;
use Vicimus\Leads\Models\Confirmation;
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
     * Handle purl submissions
     *
     * @param string[] $request The request payload
     * @param int|null $lead    The lead id to be populated
     * @param bool     $testing Was this a testing submission
     *
     * @return Confirmation
     *
     * @throws PurlSubmissionException
     * @throws RestException
     */
    public function submission(array $request, ?int &$lead = null, bool $testing = false): Confirmation;

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
