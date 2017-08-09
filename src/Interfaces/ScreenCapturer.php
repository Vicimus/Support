<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface ScreenCapturer
 *
 * @package Vicimus\Support\Interfaces
 */
interface ScreenCapturer
{
    /**
     * Convert a URL into a JPG representation of that webpage
     *
     * @param string $url
     *
     * @return string
     */
    public function jpg(string $url): string;

    /**
     * Convert a URL into a PNG representation of that webpage
     *
     * @param string $url
     *
     * @return string
     */
    public function png(string $url): string;

    /**
     * Convert a URL into a PDF representation of that webpage
     *
     * @param string $url
     *
     * @return string
     */
    public function pdf(string $url): string;
}
