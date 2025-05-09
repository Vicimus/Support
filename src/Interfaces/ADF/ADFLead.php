<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\ADF;

use DateTime;

/**
 * Enforces specific behaviour to allow the ADF generator to extract information
 * from a lead
 */
interface ADFLead
{
    /**
     * If a service lead, what was their alternate date and time. Return null
     * if not a service lead or if they did not provide one
     */
    public function alternateDate(): ?DateTime;

    /**
     * Return an array of comments to be included in the ADF
     *
     * @return string[]
     */
    public function comments(): array;

    /**
     * Return an ADFCustomer describing the customer who submitted this lead.
     *
     * If there is no customer information you can return null. Returning null
     * will most likely interrupt the ADF generation and prevent an ADF from
     * being sent because without a customer, there is no point.
     */
    public function customer(): ?ADFCustomer;

    /**
     * Retrieve the name of the form used with the submission
     */
    public function formType(): ?string;

    /**
     * This should be a unique identifier for the lead.  Most likely the primary
     * key from the database
     */
    public function identifier(): int;

    /**
     * Should return the interest of the lead. Should be something like
     * service, buy, lease, finance, etc
     */
    public function interest(): ?string;

    /**
     * Should return a string indicating the type of lead this is
     */
    public function leadType(): string;

    /**
     * If a service lead, what was their preferred date and time. Return null
     * if not a service lead
     */
    public function preferredDate(): ?DateTime;

    /**
     * If this lead is related to a vehicle, this method should return an
     * ADFVehicle instance to describe that vehicle.
     */
    public function vehicle(): ?ADFVehicle;

    /**
     */
    public function vehicleOfInterest(): ?ADFVehicle;

    public function withToken(string $token): mixed;
}
