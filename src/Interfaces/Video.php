<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Video
 */
interface Video
{
    /**
     * Get the type of video ie/ youtube, flickfusion, etc.
     *
     * @return string
     */
    public function videoType(): string;

    /**
     * Get the value for the video
     *
     * @return string
     */
    public function videoValue(): string;
}
