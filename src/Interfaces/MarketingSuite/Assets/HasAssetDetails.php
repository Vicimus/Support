<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

/**
 * Interface HasAssetDetails
 */
interface HasAssetDetails
{
    /**
     * Asset errored with the provided payload
     *
     * @param string $message The error message
     *
     * @return void
     */
    public function error(string $message): void;
}
