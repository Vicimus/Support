<?php

namespace Vicimus\Support\Interfaces\ADF;

/**
 * Enforces methods required to generate ADFs containing customer information
 */
interface ADFCustomer
{
    /**
     * Get the firstname of this customer
     *
     * @return string
     */
    public function firstname() : string;

    /**
     * Get the lastname of this customer
     *
     * @return string
     */
    public function lastname() : string;

    /**
     * Get the street address of the customer if available.
     * Return null if it is not available
     *
     * @return string
     */
    public function street() : ?string;

    /**
     * Return an array of address related properties. Things like city,
     * country, postal code. The ADF generator will loop over these
     * properties and include them.
     *
     * @return string
     */
    public function address() : array;

    /**
     * Include any other properties you wish to have printed in the ADF here.
     *
     * @return array
     */
    public function toArray() : array;
}