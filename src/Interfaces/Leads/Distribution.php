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
    public function debug(): string;

    /**
     * @return string
     */
    public function getHeaders(): string;

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

    /**
     * @return string|null
     */
    public function http(): ?string;
}
