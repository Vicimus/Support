<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

/**
 * Interface Downloader
 */
interface Downloader
{
    /**
     * Download a photo or set of photos, figured out by examining the
     * download request
     *
     * @param DownloadRequest $request The request to process
     *
     * @return mixed
     */
    public function download(DownloadRequest $request);
}
