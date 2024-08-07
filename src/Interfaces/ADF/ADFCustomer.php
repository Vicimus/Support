<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\ADF;

/**
 * Enforces methods required to generate ADFs containing customer information
 */
interface ADFCustomer
{
    /**
     * Return an array of address related properties. Things like city,
     * country, postal code. The ADF generator will loop over these
     * properties and include them.
     *
     * @return string[]
     */
    public function address(): array;

    /**
     * Get the firstname of this customer
     */
    public function firstname(): string;

    /**
     * Get the lastname of this customer
     */
    public function lastname(): string;

    /**
     * Get the id of this customer
     */
    public function primaryId(): ?int;

    /**
     * Get the street address of the customer if available.
     * Return null if it is not available
     */
    public function street(): ?string;

    /**
     * Include any other properties you wish to have printed in the ADF here.
     *
     * @return string[]
     */
    public function toAdfArray(): array;
}
