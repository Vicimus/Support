<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

interface Downloader
{
    /**
     * Download a photo or set of photos, figured out by examining the
     * download request
     */
    public function download(DownloadRequest $request): mixed;
}
