<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Photo
 */
interface Photo
{
    /**
     * Get the etag for this photo resource
     *
     * @return string
     */
    public function etag(): ?string;

    /**
     * Get the local stored path for the photo
     *
     * @return string
     */
    public function local(): ?string;

    /**
     * Get the origin of this photo. This may be a remote url, or
     * it could be the same as the local url if it wasn't sourced
     * from somewhere.
     *
     * @return string
     */
    public function origin(): string;
}
