<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface Asset
 *
 * @property string $template
 * @property mixed[] $tabs
 */
interface Asset
{
    /**
     * Get the rendered markup
     * @return string
     */
    public function rendered(): string;
}
