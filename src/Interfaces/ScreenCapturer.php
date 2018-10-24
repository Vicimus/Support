<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

use Vicimus\Support\Classes\RenderSpecs;

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
     * @param string      $url   The URL to capture
     * @param RenderSpecs $specs Specifications for how to render
     *
     * @return string
     */
    public function pdf(string $url, RenderSpecs $specs): string;

    /**
     * Convert a URL into a PNG representation of that web-page
     *
     * @param string $url The URL to capture
     *
     * @return string
     */
    public function png(string $url): string;
}
