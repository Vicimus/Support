<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

use Vicimus\Support\Classes\RenderSpecs;

/**
 * Interface ScreenCapturer
 */
interface ScreenCapturer
{
    /**
     * Get HTML to represent the... HTML
     *
     * @param string           $url   The url to capture
     * @param RenderSpecs|null $specs The specs
     *
     * @return string
     */
    public function html(string $url, ?RenderSpecs $specs = null): string;

    /**
     * Convert a URL into a JPG representation of that web-page
     *
     * @param string      $url   The URL to capture
     * @param RenderSpecs $specs The render specs
     *
     * @return string
     */
    public function jpg(string $url, ?RenderSpecs $specs = null): string;

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
     * @param string      $url   The URL to capture
     * @param RenderSpecs $specs The specs
     *
     * @return string
     */
    public function png(string $url, ?RenderSpecs $specs = null): string;
}
