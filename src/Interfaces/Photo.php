<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

use Vicimus\Support\Classes\API\Headers;
use Vicimus\Support\Classes\Photos\PhotoStatus;

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

    /**
     * Get the format for creating a path
     *
     * Arguments are supplied in the following order:
     *
     * @return string
     */
    public function pathFormat(): string;

    /**
     * Get an instance of photo status
     *
     * @param Headers $headers The headers that will define the status
     * @param Vehicle $vehicle The vehicle related to this photo
     *
     * @return PhotoStatus
     */
    public function status(Headers $headers, Vehicle $vehicle): PhotoStatus;

    /**
     * Update the model in the database.
     *
     * @param string[] $attributes Attributes to update
     * @param string[] $options    Additional options
     *
     * @return bool|mixed
     */
    public function update(array $attributes = [], array $options = []);
}
