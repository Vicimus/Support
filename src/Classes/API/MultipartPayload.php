<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\API;

use Illuminate\Http\File;
use Vicimus\Support\Classes\ImmutableObject;

/**
 * Class MultipartPayload
 */
class MultipartPayload extends ImmutableObject
{
    /**
     * MultipartPayload constructor.
     *
     * @param string      $name     The name of this payload line
     * @param File|mixed  $contents The content (string or file resource)
     * @param null|string $filename The filename (Optional)
     * @param null|string $mime     The mime type
     */
    public function __construct(
        string $name,
        $contents,
        ?string $filename = null,
        ?string $mime = null
    ) {
        parent::__construct([
            'name' => $name,
            'contents' => $contents,
            'filename' => $filename,
            'mime' => $mime,
        ]);
    }

    /**
     * Format an instance into a valid multipart transmission format
     *
     * @return mixed[]
     */
    public function format(): array
    {
        if ($this->hasFile()) {
            return [
                'Content-Type' => 'multipart/form-data',
                'name' => $this->name,
                'contents' => fopen($this->contents->getPathname(), 'r'),
                'filename' => $this->filename ?? $this->contents->getFilename(),
                'mime' => $this->mime ?? $this->contents->getMimeType(),
            ];
        }

        return [
            'Content-Type' => 'application/json',
            'name' => $this->name,
            'contents' => is_string($this->contents) ? $this->contents : json_encode($this->contents),
        ];
    }

    /**
     * Check if the payload has a file or not
     *
     * @return bool
     */
    public function hasFile(): bool
    {
        return $this->contents instanceof File;
    }
}
