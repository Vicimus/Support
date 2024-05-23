<?php

declare(strict_types=1);

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
     */
    public function html(string $url, ?RenderSpecs $specs = null): string;

    /**
     * Convert a URL into a JPG representation of that web-page
     *
     * @param string           $url     The URL to capture
     * @param RenderSpecs|null $specs   The render specs
     * @param string           $command The command run, by reference
     *
     */
    public function jpg(string $url, ?RenderSpecs $specs = null, string &$command = ''): string;

    /**
     * Convert a URL into a PDF representation of that web-page
     *
     * @param string      $url     The URL to capture
     * @param RenderSpecs $specs   Specifications for how to render
     * @param string      $command The command run, by reference
     *
     */
    public function pdf(string $url, RenderSpecs $specs, string &$command = ''): string;

    /**
     * Capture a batch of requests into many pdfs re-using the same browser and page
     *
     * @param string $baseUrl The base url to the pdf service
     * @param string $uuid    The batch uuid
     * @param string $command The command that was run
     *
     */
    public function pdfBatch(string $baseUrl, string $uuid, string &$command = ''): void;

    /**
     * Convert a URL into a PNG representation of that web-page
     *
     * @param string           $url     The URL to capture
     * @param RenderSpecs|null $specs   The specs
     * @param string           $command The command run, by reference
     *
     */
    public function png(string $url, ?RenderSpecs $specs = null, string &$command = ''): string;

    /**
     * Convert a URL into a Web P
     *
     * @param string           $url     The URL to capture
     * @param RenderSpecs|null $specs   The specs
     * @param string           $command The command run, by reference
     */
    public function webp(string $url, ?RenderSpecs $specs = null, string &$command = ''): string;
}
