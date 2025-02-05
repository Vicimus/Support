<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Leads;

interface Distribution
{
    /**
     * @return string
     */
    public function getHttpProviderId(): string;

    /**
     * @return string
     */
    public function getHttpVendorId(): string;
}
