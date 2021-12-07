<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

/**
 * Interface HasAssetDetails
 */
interface HasAssetDetails
{
    /**
     * Set the error on asset details with the provided message
     *
     * @param string $message The error message
     *
     * @return void
     */
    public function setError(string $message): void;
}
