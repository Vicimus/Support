<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use Vicimus\Support\Classes\RenderSpecs;

interface ScreenCapturer
{
    /**
     * Get HTML to represent the... HTML
     */
    public function html(string $url, ?RenderSpecs $specs = null): string;

    /**
     * Convert a URL into a JPG representation of that web-page
     */
    public function jpg(string $url, ?RenderSpecs $specs = null, string &$command = ''): string;

    /**
     * Convert a URL into a PDF representation of that web-page
     */
    public function pdf(string $url, RenderSpecs $specs, string &$command = ''): string;

    /**
     * Capture a batch of requests into many pdfs re-using the same browser and page
     */
    public function pdfBatch(string $baseUrl, string $uuid, string &$command = ''): void;

    /**
     * Convert a URL into a PNG representation of that web-page
     */
    public function png(string $url, ?RenderSpecs $specs = null, string &$command = ''): string;

    /**
     * Convert a URL into a WebP
     */
    public function webp(string $url, ?RenderSpecs $specs = null, string &$command = ''): string;
}
