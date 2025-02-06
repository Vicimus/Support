<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Leads;

/**
 * Represent a lead distribution with configuration information
 */
interface Distribution
{
    /**
     * @return string
     */
    public function getHttpAdfFormat(): string;

    /**
     * @return string
     */
    public function getHttpProviderId(): string;

    /**
     * @return string
     */
    public function getHttpVendorId(): string;

    /**
     * @return int
     */
    public function getStoreId(): int;
}
