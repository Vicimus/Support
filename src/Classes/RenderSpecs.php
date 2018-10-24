<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

/**
 * Class RenderSpecs
 * @property int $width
 * @property int $height
 * @property int $scale
 * @property int $pages
 */
class RenderSpecs extends ImmutableObject
{
    /**
     * RenderSpecs constructor.
     *
     * @param int|null $width  The width of the pdf element
     * @param int|null $height The height of the pdf element
     * @param int|null $scale  The scale to use
     * @param int|null $pages  The number of pages
     */
    public function __construct(?int $width, ?int $height, ?int $scale, ?int $pages)
    {
        parent::__construct([
            'width' => $width,
            'height' => $height,
            'scale' => $scale,
            'pages' => $pages,
        ]);
    }
}
