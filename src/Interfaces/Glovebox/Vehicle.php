<?php

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface Vehicle
 *
 * @property int $id
 * @property int $year
 * @property string $make
 * @property string $model
 * @property string $trim
 * @property string $style_id
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
    public function getMainPhoto($thumbnail = false, $checkExists = false);

    /**
     * Get the URL to view the VDP of the vehicle. This applies various
     * replaces to stop any issues with the URL generation.
     *
     * @param string $source OPTIONAL Source string to be added to the URL
     *
     * @return string
     */
    public function getUrl($source = null);
}
