<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface Vehicle
 */
interface Vehicle
{
    /**
     * Gets the path to the main photo of the vehicle. The main photo is the
     * one photo used to display on VLPs and other areas. If no photo is found
     * it will display a default photo.
     *
     * @param bool $thumbnail   Pass true to get a thumbnail size
     * @param bool $checkExists Pass true to verify the photo exists
     *
     * @return string
     */
    public function getMainPhoto(bool $thumbnail = false, bool $checkExists = false): string;

    /**
     * Get the URL to view the VDP of the vehicle. This applies various
     * replaces to stop any issues with the URL generation.
     *
     * @param string $source OPTIONAL Source string to be added to the URL
     *
     * @return string
     */
    public function getUrl(?string $source = null): string;
}
