<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Exports;

use Vicimus\Support\Classes\ImmutableObject;

class ExportArtifact extends ImmutableObject
{
    public function __construct(
        public string $disk,
        public string $path,
        public string $filename,
        public int $size,
    ) {
        parent::__construct([
            'disk' => $disk,
            'path' => $path,
            'filename' => $filename,
            'size' => $size,
        ]);
    }
}
