<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Leads;

/**
 * Represent a lead distribution with configuration information
 */
interface Distribution
{
    /**
     */
    public function debug(): string;

    /**
     */
    public function getHeaders(): string;

    /**
     */
    public function getHttpAdfFormat(): string;

    /**
     */
    public function getHttpProviderId(): string;

    /**
     */
    public function getHttpVendorId(): string;

    /**
     */
    public function getStoreId(): int;

    /**
     */
    public function http(): ?string;
}
