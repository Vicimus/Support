<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface ScreenCapturer
 */
interface ScreenCapturer
{
    /**
     * Convert a URL into a JPG representation of that web-page
     *
     * @param string $url The URL to capture
     *
     * @return string
     */
    public function jpg(string $url): string;

    /**
     * Convert a URL into a PDF representation of that web-page
     *
     * @param string $url    The URL to capture
     * @param int    $width  The width of the entity or screen
     * @param int    $height The height of the entity or screen
     * @param int    $scale  The value to scale to
     * @param int    $pages  The number of pages to limit to
     *
     * @return string
     */
    public function pdf(string $url, ?int $width, ?int $height, ?int $scale, ?int $pages): string;

    /**
     * Convert a URL into a PNG representation of that web-page
     *
     * @param string $url The URL to capture
     *
     * @return string
     */
    public function png(string $url): string;
}
