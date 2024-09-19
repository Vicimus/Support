<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface Vehicle
{
    /**
     * Gets the path to the main photo of the vehicle. The main photo is the
     * one photo used to display on VLPs and other areas. If no photo is found
     * it will display a default photo.
     */
    public function getMainPhoto(bool $thumbnail = false, bool $checkExists = false): string;

    /**
     * Get the URL to view the VDP of the vehicle. This applies various
     * replaces to stop any issues with the URL generation.
     */
    public function getUrl(?string $source = null): string;
}
