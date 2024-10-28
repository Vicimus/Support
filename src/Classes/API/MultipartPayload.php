<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\API;

use Illuminate\Http\File;
use Vicimus\Support\Classes\ImmutableObject;

class MultipartPayload extends ImmutableObject
{
    public function __construct(
        string $name,
        mixed $contents,
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
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
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
     */
    public function hasFile(): bool
    {
        return $this->contents instanceof File;
    }
}
